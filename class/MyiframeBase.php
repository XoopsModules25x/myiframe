<?php declare(strict_types=1);

namespace XoopsModules\Myiframe;

/**
 * ****************************************************************************
 * MYIFRAME - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (https://www.instant-zero.com)
 * ****************************************************************************
 */
require_once XOOPS_ROOT_PATH . '/kernel/object.php';

/**
 * Class Myiframe
 */
class MyiframeBase extends \XoopsObject
{
    //    /** @var \XoopsMySQLDatabase */
    public $db;

    /**
     * myiframe constructor.
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->db = \XoopsDatabaseFactory::getDatabaseConnection();
        $this->initVar('frame_frameid', \XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('frame_created', \XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('frame_uid', \XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('frame_description', \XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('frame_width', \XOBJ_DTYPE_TXTBOX, null, false, 15);
        $this->initVar('frame_height', \XOBJ_DTYPE_TXTBOX, null, false, 15);
        $this->initVar('frame_align', \XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('frame_frameborder', \XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('frame_marginwidth', \XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('frame_marginheight', \XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('frame_scrolling', \XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('frame_hits', \XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('frame_url', \XOBJ_DTYPE_TXTBOX, null, false, 255);
        if (!empty($id)) {
            if (\is_array($id)) {
                $this->assignVars($id);
            } else {
                $this->load((int)$id);
            }
        } else {
            $this->setNew();
        }
    }

    /**
     * @param $id
     */
    public function load($id): void
    {
        $sql   = 'SELECT * FROM ' . $this->db->prefix('myiframe') . ' WHERE frame_frameid=' . (int)$id;
        $myrow = $this->db->fetchArray($this->db->query($sql));
        $this->assignVars($myrow);
        if (!$myrow) {
            $this->setNew();
        }
    }
}
