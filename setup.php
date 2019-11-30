<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include 'functions.php';

/*createTable('login',
            'username VARCHAR(128),
            password VARCHAR(16)'
            );
*/
createTable('staff',
            'id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            lastname VARCHAR(32),
            firstname VARCHAR(32),
            othername VARCHAR(32)');

createTable('staffpdetail',
            'id INT UNSIGNED NOT NULL PRIMARY KEY,
            mobile VARCHAR(16),
            phone VARCHAR(16),
            email VARCHAR(128),
            address VARCHAR(256)');

createTable('staffwdetail',
            'id INT UNSIGNED NOT NULL PRIMARY KEY,
            designation VARCHAR(32),
            dept VARCHAR(32),
            branch VARCHAR(32)');
?>
