window.base_api = '';
require('./main');

if(['account.show'].includes(route)) {
    require('./account');
}

if(['user.index','user.show'].includes(route)) {
    require('./user');
}

if(['contact.index','contact.show'].includes(route)) {
    require('./contact');
}

if(['role.index','role.show'].includes(route)) {
    require('./role');
}

if(['permission.index','permission.show'].includes(route)) {
    require('./permission');
}



