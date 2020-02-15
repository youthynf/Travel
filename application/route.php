<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
//    '[hello]'     => [
//        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//        ':name' => ['index/hello', ['method' => 'post']],
//    ],
    // 路由参数name为可选
    'hello/[:name]' => 'index/hello',

    'blog/[:id]' => 'article/blog',
    'blogs' => 'article/blogs',

    'place/[:id]' => 'article/place',
    'places' => 'article/places',
    'hotel/[:id]' => 'article/hotel',
    'hotels' => 'article/hotels',
    'addComment' => 'article/addComment',

    'addOrder' => 'orders/addOrder',

    'restaurant/[:id]' => 'article/restaurant',
    'restaurants' => 'article/restaurants',

    'user' => 'user/index',
    'user_reg' => 'user/reg',
    'user_login' => 'user/login',
    'user_update' => 'user/update',
    'user_logout' => 'user/logout',

    'admin_login' => 'admin/user/login',
    'admin' => 'admin/index/index',
    'admin/statistic' => 'admin/index/statistic',
    'admin/checkLogin' => 'admin/user/checkLogin',
    'admin_logout' => 'admin/user/logout',

    'admin/user_list' => 'admin/user/user_list',

    'admin/admin_list' => 'admin/user/admin_list',
    'admin/saveAdmin' => 'admin/user/saveAdmin',
    'admin/delOne' => 'admin/user/delOne',
    'admin/delAll' => 'admin/user/delAll',
    'admin/editStatus' => 'admin/user/editStatus',

    'admin/place_list' => 'admin/place/index',
    'admin/place_img' => 'admin/place/uploadImg',
    'admin/savePlace' => 'admin/place/savePlace',
    'admin/delOnePlace' => 'admin/place/delOne',
    'admin/delAllPlace' => 'admin/place/delAll',
    'admin/editPlaceStatus' => 'admin/place/editStatus',

    'admin/hotel_list' => 'admin/hotel/index',
    'admin/saveHotel' => 'admin/hotel/saveHotel',
    'admin/delOneHotel' => 'admin/hotel/delOne',
    'admin/delAllHotel' => 'admin/hotel/delAll',
    'admin/editHotelStatus' => 'admin/hotel/editStatus',

    'admin/restaurant_list' => 'admin/restaurant/index',
    'admin/saveRestaurant' => 'admin/restaurant/saveRestaurant',
    'admin/delOneRestaurant' => 'admin/restaurant/delOne',
    'admin/delAllRestaurant' => 'admin/restaurant/delAll',
    'admin/editRestaurantStatus' => 'admin/restaurant/editStatus',

    'admin/article_list' => 'admin/article/index',
    'admin/saveArticle' => 'admin/article/saveArticle',
    'admin/delOneArticle' => 'admin/article/delOne',
    'admin/delAllArticle' => 'admin/article/delAll',
    'admin/editArticleStatus' => 'admin/article/editStatus',

    'admin/room_list' => 'admin/room/index',
    'admin/saveRoom' => 'admin/room/saveRoom',
    'admin/delOneRoom' => 'admin/room/delOne',
    'admin/delAllRoom' => 'admin/room/delAll',
    'admin/editRoomStatus' => 'admin/room/editStatus',

    'admin/food_list' => 'admin/food/index',
    'admin/saveFood' => 'admin/food/saveFood',
    'admin/delOneFood' => 'admin/food/delOne',
    'admin/delAllFood' => 'admin/food/delAll',
    'admin/editFoodStatus' => 'admin/food/editStatus',
];
