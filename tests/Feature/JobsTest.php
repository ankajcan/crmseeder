<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Job;
use App\Models\User;
use App\Models\UserItem;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use \Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\File\UploadedFile as SymfonyUploadedFile;

use Tests\TestCase;

class JobsTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
        $this->authenticateUser();
        factory(\App\Models\Item::class)->states('custom_item')->create();
    }

    /** @test */
    public function can_see_jobs_where_user_is_assigned()
    {
        $job = factory(\App\Models\Job::class)->create();
        $job2 = factory(\App\Models\Job::class)->create();

        // Assign user to a job
        factory(\App\Models\JobUser::class)->create(['user_id' => $this->user->id, 'job_id' => $job->id]);

        $response = $this->json('GET', 'api/v1/jobs', []);

        $response->assertStatus(200)->assertJsonFragment(["id" => $job->id]);
        $response->assertJsonMissing(["id" => $job2->id]);
    }

    /** @test */
    public function can_update_job_substatus()
    {
        $job = factory(\App\Models\Job::class)->create();

        // Assign user to a job
        factory(\App\Models\JobUser::class)->create(['user_id' => $this->user->id, 'job_id' => $job->id]);

        $data = [
            'substatus_id' => Job::SUBSTATUS_LOADING
        ];

        $response = $this->json('PUT', 'api/v1/jobs/'.$job->id.'/substatus', $data);

        $data = $response->json()['data'];
        $response->assertStatus(200)->assertJsonFragment(["id" => $job->id]);
        $this->assertEquals($data['substatus_id'],Job::SUBSTATUS_LOADING);
    }

    /** @test */
    public function can_see_items_in_job()
    {
        $job = factory(\App\Models\Job::class)->create();
        // Assign user to a job
        factory(\App\Models\JobUser::class)->create(['user_id' => $this->user->id, 'job_id' => $job->id]);

        $userJobItem1 = factory(\App\Models\UserJobItem::class)->create(['job_id' => $job->id]);
        $userJobItem2 = factory(\App\Models\UserJobItem::class)->create(['job_id' => $job->id]);

        $response = $this->json('GET', 'api/v1/jobs/'.$job->id."/items", []);


        $this->assertEquals(count($response->json()['data']),2);

        $response->assertStatus(200);
    }

    /** @test */
    public function can_add_item_in_job()
    {
        $job = factory(\App\Models\Job::class)->create();
        // Assign user to a job
        factory(\App\Models\JobUser::class)->create(['user_id' => $this->user->id, 'job_id' => $job->id]);

        $item = factory(\App\Models\Item::class)->create();

        $data = [
            'item_id' => $item->id,
            'image' => UploadedFile::fake()->image('RomanianTestImage2017.jpg'),
            'status_id' => UserItem::STATUS_COLLECTED
        ];

        $response = $this->json('POST', 'api/v1/jobs/'.$job->id."/item", $data);

        $data = $response->json()['data'];

        $this->assertEquals($data['name'],$item->name);
        $this->assertContains('RomanianTestImage2017.jpg',$data['image']);

        $this->assertDatabaseHas('user_job_items',['job_id'=>$job->id]);
    }

    /** @test */
    public function can_add_custom_item_in_job()
    {
        $job = factory(\App\Models\Job::class)->create();
        // Assign user to a job
        factory(\App\Models\JobUser::class)->create(['user_id' => $this->user->id, 'job_id' => $job->id]);

        $item = factory(\App\Models\Item::class)->create();

        $data = [
            'item_id' => Item::CUSTOM_ITEM_ID,
            'image' => UploadedFile::fake()->image('RomanianTestImage2017.jpg'),
            'name' => 'Custom Item',
            'status_id' => UserItem::STATUS_COLLECTED
        ];

        $response = $this->json('POST', 'api/v1/jobs/'.$job->id."/item", $data);

        $data = $response->json()['data'];

        $this->assertEquals($data['name'],'Custom Item');
        $this->assertContains('RomanianTestImage2017.jpg',$data['image']);

        $this->assertDatabaseHas('user_job_items',['job_id'=>$job->id]);
        $this->assertDatabaseHas('user_items',['name' => 'Custom Item']);
    }

    /** @test */
    public function can_edit_user_item()
    {
        $job = factory(\App\Models\Job::class)->create();
        // Assign user to a job
        factory(\App\Models\JobUser::class)->create(['user_id' => $this->user->id, 'job_id' => $job->id]);

        $userJobItem = factory(\App\Models\UserJobItem::class)->create(['job_id' => $job->id]);
        $userItem = $userJobItem->userItem;

        $data = [
            'image' => UploadedFile::fake()->image('RomanianTestImage2017.jpg'),
            'description' => 'Let description be different',
            'status_id' => UserItem::STATUS_COLLECTED
        ];

        $response = $this->json('PUT', 'api/v1/user-item/'.$userItem->id, $data);

        $data = $response->json()['data'];

        $response->assertStatus(200);
        $this->assertEquals($data['description'],'Let description be different');
        $this->assertContains('RomanianTestImage2017.jpg',$data['image']);
    }

    /** @test */
    public function can_delete_user_item()
    {
        $job = factory(\App\Models\Job::class)->create();
        // Assign user to a job
        factory(\App\Models\JobUser::class)->create(['user_id' => $this->user->id, 'job_id' => $job->id]);

        $userJobItem = factory(\App\Models\UserJobItem::class)->create(['job_id' => $job->id]);
        $userItem = $userJobItem->userItem;

        $response = $this->json('DELETE', 'api/v1/user-job-item/'.$userJobItem->id, []);

        $data = $response->json();

        $response->assertStatus(200);
        $this->assertEquals($data['success'],true);
        $this->assertDatabaseMissing('user_job_items',['job_id' => $job->id, 'user_item_id' => $userItem->id]);
        $this->assertDatabaseHas('user_items',[ 'id' => $userItem->id ]);

    }

    /** @test */
    public function user_item_status_update_on_job_substatus_driving_update()
    {
        $job = factory(\App\Models\Job::class)->create();

        // Assign user to a job
        factory(\App\Models\JobUser::class)->create(['user_id' => $this->user->id, 'job_id' => $job->id]);
        $userJobItem = factory(\App\Models\UserJobItem::class)->create(['job_id' => $job->id]);
        $userItem = $userJobItem->userItem;

        $data = [
            'substatus_id' => Job::SUBSTATUS_DRIVING
        ];

        $response = $this->json('PUT', 'api/v1/jobs/'.$job->id.'/substatus', $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('user_items',[ 'id' => $userItem->id, 'status_id' => UserItem::STATUS_IN_TRANSPORT ]);
    }

}
