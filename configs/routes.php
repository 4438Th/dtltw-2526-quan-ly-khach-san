<?php
return [
    // Default routes
    'defaultModule' => 'HomeModule',
    'defaultController' => 'HomeController',
    'defaultAction' => 'index',
    'defaultParams' => [],
    // Custom routes
    'customRoutes' => [
        // route không tham số
        'GET /home'  => [
            'module'    => 'HomeModule',
            'controller' => 'HomeController',
            'action'    => 'index',
        ],
        'GET /lab'  => [
            'module'    => 'LabModule',
            'controller' => 'LabController',
            'action'    => 'index',
        ],

        // URL: /api/rooms
        // GET: Lấy TẤT CẢ phòng
        'GET /api/rooms' => [
            'module'     => 'HomeModule',
            'controller' => 'HomeController',
            'action'     => 'getRooms',
        ],

        // POST: TẠO phòng mới
        'POST /api/rooms' => [
            'module'     => 'HomeModule',
            'controller' => 'HomeController',
            'action'     => 'createRoom',
        ],
        // URL: /api/rooms/{id}
        // GET: Lấy thông tin MỘT phòng (có tham số ID)
        'GET /api/rooms/{id}' => [
            'module'     => 'HomeModule',
            'controller' => 'HomeController',
            'action'     => 'getRoom',
        ],

        // PUT: CẬP NHẬT thông tin MỘT phòng (có tham số ID)
        'PUT /api/rooms/{id}' => [
            'module'     => 'HomeModule',
            'controller' => 'HomeController',
            'action'     => 'updateRoom',
        ],

        // DELETE: XÓA MỘT phòng (có tham số ID)
        'DELETE /api/rooms/{id}' => [
            'module'     => 'HomeModule',
            'controller' => 'HomeController',
            'action'     => 'deleteRoom',
        ],
    ]
];
