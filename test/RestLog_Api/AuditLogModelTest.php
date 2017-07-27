<?php
/*
 * This file is part of Pluf Framework, a simple PHP Application Framework.
 * Copyright (C) 2010-2020 Phoinex Scholars Co. http://dpq.co.ir
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
use PHPUnit\Framework\TestCase;
require_once 'Pluf.php';

/**
 * Check cache middleware functionality
 *
 * @author pluf.ir<info@pluf.ir>
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 */
class RestLog_Api_AuditLogModelTestTest extends TestCase
{
    
    /**
     * Creates DBMS
     * 
     * @beforeClass
     */
    public static function createDataBase ()
    {
        Pluf::start(
                array(
                        'test' => false,
                        'timezone' => 'Europe/Berlin',
                        'debug' => true,
                        'installed_apps' => array(
                                'Pluf'
                        ),
                        'tmp_folder' => dirname(__FILE__) . '/../tmp',
                        'templates_folder' => array(
                                dirname(__FILE__) . '/../templates'
                        ),
                        'pluf_use_rowpermission' => true,
                        'mimetype' => 'text/html',
                        'app_views' => dirname(__FILE__) . '/views.php',
                        'db_login' => 'testpluf',
                        'db_password' => 'testpluf',
                        'db_server' => 'localhost',
                        'db_database' => dirname(__FILE__) .
                        '/../tmp/tmp.sqlite.db',
                        'app_base' => '/testapp',
                        'url_format' => 'simple',
                        'db_table_prefix' => 'rest_audit_unit_tests_',
                        'db_version' => '5.0',
                        'db_engine' => 'SQLite',
                        'bank_debug' => true
                ));
        
        $db = Pluf::db();
        $schema = Pluf::factory('Pluf_DB_Schema', $db);
        $models = array(
                'RestLog_AuditLog'
        );
        foreach ($models as $model) {
            $schema->model = Pluf::factory($model);
            $schema->dropTables();
            if (true !== ($res = $schema->createTables())) {
                throw new Exception($res);
            }
        }
    }
    
    /**
     * Remove all created DBMS
     * 
     * @afterClass
     */
    public static function removeDatabses ()
    {
        $db = Pluf::db();
        $schema = Pluf::factory('Pluf_DB_Schema', $db);
        $models = array(
                'RestLog_AuditLog'
        );
        foreach ($models as $model) {
            $schema->model = Pluf::factory($model);
            $schema->dropTables();
        }
    }
    
    
    /**
     * Can create new instance
     *
     * @test
     */
    public function instance ()
    {
        $audit = new RestLog_AuditLog();
//         $audit->user = $request->user;
        $audit->view = 'view';
        $audit->host = 'localhost';
        $audit->method = 'get';
        $audit->resource = '/';
        $audit->request_dtime= gmdate('Y-m-d H:i:s');
        $audit->time = time();
        $this->assertTrue($audit->create());
    }
    
}