Test task for Yalantis
============================

Pomazkov A.A.
## INSTALLATION

1. $ composer update

2. CREATE DATABASE IF NOT EXISTS `yalantis` /*!40100 DEFAULT CHARACTER SET utf8 */;
   USE `yalantis`;
   
3. If your DataBase use passwords, then rewrite file: config/db.php

    3.1 'username' => 'root'    <-- your DB user
    
        'password' => ''        <-- your DB user password
        
        'charset' => 'utf8'
        
4. $ yiic migrate


##USING

#GET http://yalantis/photo

#GET http://yalantis/photo/_inserted_id_

#POST http://yalantis/photo/create AND send jpg|gif|png file

#PUT http://yalantis/photo/update/_photo_id/_new_width_/_new_height_

#DELETE http://yalantis/delete/_photo_id_

#GET http://yalantis/history

#GET http://yalantis/history/_history_id_

#DELETE http://yalantis/history/delete/_history_id_
