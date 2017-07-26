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
    
    /**
     * Records some info (in this case time of response) about provided response 
     *  
     * @param Pluf_HTTP_Request $request
     *            The request
     * @param Pluf_HTTP_Response $resonse
     *            The response
     * @return Pluf_HTTP_Response The response
     */
    function process_response ($request, $response)
    {
        $this->log->response_dtime = gmdate('Y-m-d H:i:s');
        $this->log->update();
        return $response;
    }

    function process_request ($request)
    {
        $this->log = new RestLog_AuditLog();
        $this->log->user = $request->user == null ? 0 : $request->user->id;
        $this->log->view = $request->view;
        $this->log->method = $request->method;
        $this->log->resource = $request->uri;
        $this->log->save();
        return false;
    }
}
