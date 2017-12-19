<?php

class RestLog_AuditLog extends Pluf_Model
{

    /**
     * @brief مدل داده‌ای را بارگذاری می‌کند.
     *
     * @see Pluf_Model::init()
     */
    function init()
    {
        $this->_a['table'] = 'restlog_auditlog';
        $this->_a['verbose'] = 'RestLog AuditLog';
        $this->_a['cols'] = array(
            'id' => array(
                'type' => 'Pluf_DB_Field_Sequence',
                'blank' => false,
                'editable' => false,
                'readable' => true
            ),
            'host' => array(
                'type' => 'Pluf_DB_Field_Varchar',
                'blank' => false,
                'size' => 200,
                'editable' => true,
                'readable' => true
            ),
            'method' => array(
                'type' => 'Pluf_DB_Field_Varchar',
                'blank' => true,
                'size' => 10,
                'editable' => false,
                'readable' => false
            ),
            'resource' => array(
                'type' => 'Pluf_DB_Field_Varchar',
                'blank' => true,
                'size' => 250,
                'editable' => false,
                'readable' => false
            ),
            'user' => array(
                'type' => 'Pluf_DB_Field_Foreignkey',
                'model' => 'User',
                'relate_name' => 'request_responsible',
                'blank' => true,
                'readable' => true,
                'editable' => false
            ),
            'request_dtime' => array(
                'type' => 'Pluf_DB_Field_Datetime',
                'blank' => true,
                'editable' => false,
                'readable' => true
            ),
            'time' => array(
                'type' => 'Pluf_DB_Field_Integer',
                'blank' => true,
                'is_null' => true,
                'editable' => false,
                'readable' => true
            )
        );
        
        $this->_a['idx'] = array(
            'page_class_idx' => array(
                'col' => 'user',
                'type' => 'normal', // normal, unique, fulltext, spatial
                'index_type' => '', // hash, btree
                'index_option' => '',
                'algorithm_option' => '',
                'lock_option' => ''
            )
        );
    }

    /**
     * \brief پیش ذخیره را انجام می‌دهد
     *
     * @param $create حالت
     *            ساخت یا به روز رسانی را تعیین می‌کند
     */
    function preSave($create = false)
    {
        if ($this->id == '') {
            $this->request_dtime = gmdate('Y-m-d H:i:s');
        }
    }

    /**
     * حالت کار ایجاد شده را به روز می‌کند
     *
     * @see Pluf_Model::postSave()
     */
    function postSave($create = false)
    {
        //
    }

}
