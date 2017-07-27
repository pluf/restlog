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
 * Check middleware api
 *
 * @author pluf.ir<info@pluf.ir>
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 */
class RestLog_Middleware_ResponseTest extends TestCase
{

    /**
     * Check if there is no cache config
     *
     * @test
     */
    public function notConfiguredView ()
    {
        $query = '/example/resource';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = 'http://localhost/example/resource';
        $_SERVER['REMOTE_ADDR'] = 'not set';
        $_SERVER['HTTP_HOST'] = 'localhost';
        $GLOBALS['_PX_uniqid'] = 'example';
        
        $middleware = new RestLog_Middleware_Audit();
        $request = new Pluf_HTTP_Request($query);
        $response = new Pluf_HTTP_Response('Hi!');
        
        // empty view
        $request->view = array(
                'ctrl' => array()
        );
        
//         $response = $middleware->process_response($request, $response);
//         $this->assertTrue(array_key_exists('Cache-Control', $response->headers), 
//                 '\'Cache-Control\' not found in the header.');
//         $this->assertTrue(
//                 strrpos($response->headers['Cache-Control'], 'no-store') !==
//                          false, 
//                         'The \'no-store\' phrase not exist in header \'Cache-Control\'.');
    }

}
