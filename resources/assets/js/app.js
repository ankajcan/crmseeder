window.base_api = '';
require('./main');

console.log(route);

if(['user.index','user.show'].includes(route)) {
    require('./user');
}

if(['contact.index','contact.show'].includes(route)) {
    require('./contact');
}



