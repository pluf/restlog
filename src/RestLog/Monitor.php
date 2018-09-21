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

/**
 *
 * @author maso<mostafa.barmshory@dpq.co.ir>
 * @author hadi<mohammad.hadi.mansouri@dpq.co.ir>
 * @since 0.1.0
 */
class RestLog_Monitor
{

    /**
     * Retruns number of received requests
     *
     * @param Pluf_HTTP_Request $request            
     * @param array $match            
     */
    public static function requestCount ($request, $match)
    {
        // count number of REST requests
        $cList = Pluf::factory('RestLog_RestCount')->getList();
        if ($cList->count() === 0) {
            $counter = new RestLog_RestCount();
            $counter->rest_count = 1;
            $counter->create();
        } else {
            $counter = $cList[0];
        }
        return $counter->rest_count;
    }
    
    private static function getBandwidth($prop){
        $model = Pluf::factory('RestLog_AuditLog');
        $cList = $model->getList(array(
            'count' => true,
            'view' => 'bandwidth'
        ));
        return $cList[0][$prop];
    }
    
    /**
     * Retruns total volume of bandwidth
     *
     * @param Pluf_HTTP_Request $request            
     * @param array $match            
     */
    public static function bandwidth ($request, $match)
    {
        return static::getBandwidth('total_len');
    }
    
    /**
     * Retruns volume of sent bandwidth
     *
     * @param Pluf_HTTP_Request $request            
     * @param array $match            
     */
    public static function sentBandwidth ($request, $match)
    {
        return static::getBandwidth('send_len');
    }
    
    /**
     * Retruns volume of received bandwidth
     *
     * @param Pluf_HTTP_Request $request            
     * @param array $match            
     */
    public static function receivedbandwidth ($request, $match)
    {
        return static::getBandwidth('receive_len');
    }
}
