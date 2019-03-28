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
 * RestLog middleware
 *
 * Stores logs about activities in the server which are done by calling REST by clients of server.
 *
 * @author maso<mostafa.barmshory@dpq.co.ir>
 * @author hadi<mohammad.hadi.mansouri@dpq.co.ir>
 */
class RestLog_Middleware_Audit
{

    private $log = null;

    private $time_start = 0;
    private $req_len = 0;

    /**
     * Records some info (in this case time of response) about provided response
     *
     * @param Pluf_HTTP_Request $request
     *            The request
     * @param Pluf_HTTP_Response $resonse
     *            The response
     * @return Pluf_HTTP_Response The response
     */
    function process_response($request, $response)
    {
//         if ($request->method != 'GET') {
            $this->log = new RestLog_AuditLog();
            $this->log->user = $request->user;
            $this->log->host = $request->http_host;
            $this->log->method = $request->method;
            $this->log->resource = $request->path_info;
            $this->log->request_dtime = $request->time;
            $this->log->time = round((microtime(true) - $this->time_start) * 1000);
            $this->log->request_len = $this->req_len;
            // TODO: maso, 2019: replace with $respnse->getSize()
            $this->log->response_len = strlen(serialize($response));
            $this->log->create();
//         }
        // count number of REST requests
        $cList = Pluf::factory('RestLog_RestCount')->getList();
        if ($cList->count() === 0) {
            $counter = new RestLog_RestCount();
            $counter->rest_count = 1;
            $counter->create();
        } else {
            $counter = $cList[0];
            $counter->rest_count ++;
            $counter->update();
        }
        return $response;
    }

    /**
     *
     * @param Pluf_HTTP_Request $request
     * @return boolean
     */
    function process_request($request)
    {
        // TODO: maso, 2019: replace with $request->getTime();
        $this->time_start = microtime(true);
        // TODO: maso, 2019: replace with $request->getSize();
        $this->req_len = strlen(serialize($request));
        return false;
    }
}
