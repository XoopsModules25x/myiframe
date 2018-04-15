<?php namespace XoopsModules\Myiframe;

/**
 * ****************************************************************************
 * MYIFRAME - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 * ****************************************************************************
 */

defined('XOOPS_ROOT_PATH') || die('XOOPS root path not defined.');

require_once XOOPS_ROOT_PATH . '/kernel/object.php';

/**
 * Class Myiframe
 */
class Myiframe extends \XoopsObject
{
//    /** @var \XoopsMySQLDatabase $db */
    public $db;

    /**
     * myiframe constructor.
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->db = \XoopsDatabaseFactory::getDatabaseConnection();
        $this->initVar('frame_frameid', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('frame_created', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('frame_uid', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('frame_description', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('frame_width', XOBJ_DTYPE_TXTBOX, null, false, 15);
        $this->initVar('frame_height', XOBJ_DTYPE_TXTBOX, null, false, 15);
        $this->initVar('frame_align', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('frame_frameborder', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('frame_marginwidth', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('frame_marginheight', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('frame_scrolling', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('frame_hits', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('frame_url', XOBJ_DTYPE_TXTBOX, null, false, 255);
        if (!empty($id)) {
            if (is_array($id)) {
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
    public function load($id)
    {
        $sql   = 'SELECT * FROM ' . $this->db->prefix('myiframe') . ' WHERE frame_frameid=' . (int)$id;
        $myrow = $this->db->fetchArray($this->db->query($sql));
        $this->assignVars($myrow);
        if (!$myrow) {
            $this->setNew();
        }
    }
}

/**
 * Class MyiframeMyiframeHandler
 */
class MyiframeMyiframeHandler extends \XoopsObjectHandler
{
    /**
     * @param bool $isNew
     * @return myiframe
     */
    public function create($isNew = true)
    {
        $object = new Myiframe();
        if ($isNew) {
            $object->setNew();
        }

        return $object;
    }

    /**
     * @param int $id
     * @return myiframe|null
     */
    public function get($id)
    {
        $ret = null;
        $sql = 'SELECT * FROM ' . $this->db->prefix('myiframe') . '  WHERE frame_frameid=' . (int)$id;
        if (!$result = $this->db->query($sql)) {
            return $ret;
        }
        $numrows = $this->db->getRowsNum($result);
        if (1 == $numrows) {
            $object = new Myiframe();
            $object->assignVars($this->db->fetchArray($result));
            return $object;
        }

        return $ret;
    }

    /**
     * @param XoopsObject $object
     * @param bool        $force
     * @return bool
     */
    public function insert(\XoopsObject $object, $force = false)
    {
        if (!$object instanceof \Myiframe) {
            return false;
        }
        if (!$object->isDirty()) {
            return true;
        }
        if (!$object->cleanVars()) {
            foreach ($object->getErrors() as $oneerror) {
                trigger_error($oneerror);
            }
            return false;
        }
        foreach ($object->cleanVars as $k => $v) {
            ${$k} = $v;
        }

        if ($object->isNew()) {
            $format = 'INSERT INTO `%s` (frame_created, frame_uid, frame_description, frame_width, frame_height, frame_align, frame_frameborder, frame_marginwidth, frame_marginheight, frame_scrolling, frame_hits, frame_url) VALUES (%u, %u, %s, %s, %s, %d, %d, %d, %d, %d, %u, %s)';
            $sql    = sprintf(
                $format,
                $this->db->prefix('myiframe'),
                $frame_created,
                $frame_uid,
                $this->db->quoteString($frame_description),
                $this->db->quoteString($frame_width),
                $this->db->quoteString($frame_height),
                $frame_align,
                $frame_frameborder,
                $frame_marginwidth,
                $frame_marginheight,
                              $frame_scrolling,
                $frame_hits,
                $this->db->quoteString($frame_url)
            );
            $force  = true;
        } else {
            $format = 'UPDATE `%s` SET frame_description=%s, frame_width=%s, frame_height=%s, frame_align=%d, frame_frameborder=%d, frame_marginwidth=%d, frame_marginheight=%d, frame_scrolling=%d, frame_hits=%u, frame_url=%s WHERE frame_frameid=%u';
            $sql    = sprintf(
                $format,
                $this->db->prefix('myiframe'),
                $this->db->quoteString($frame_description),
                $this->db->quoteString($frame_width),
                $this->db->quoteString($frame_height),
                $frame_align,
                $frame_frameborder,
                $frame_marginwidth,
                $frame_marginheight,
                $frame_scrolling,
                $frame_hits,
                              $this->db->quoteString($frame_url),
                $frame_frameid
            );
        }
        if (false !== $force) {
            $result = $this->db->queryF($sql);
        } else {
            $result = $this->db->query($sql);
        }
        if (!$result) {
            return false;
        }
        if (empty($frame_frameid)) {
            $frame_frameid = $this->db->getInsertId();
        }
        $object->assignVar('frame_frameid', $frame_frameid);

        return $frame_frameid;
    }

    /**
     * @param XoopsObject $object
     * @param bool        $force
     * @return bool
     */
    public function delete(\XoopsObject $object, $force = false)
    {
        if (!$object instanceof \Myiframe) {
            return false;
        }
        $sql = sprintf('DELETE FROM `%s` WHERE frame_frameid = %u', $this->db->prefix('myiframe'), $object->getVar('frame_frameid'));
        if (false !== $force) {
            $result = $this->db->queryF($sql);
        } else {
            $result = $this->db->query($sql);
        }
        if (!$result) {
            return false;
        }

        return true;
    }

    /**
     * @param null|\Criteria  $criteria
     * @param bool $id_as_key
     * @return array
     */
    public function &getObjects(Criteria $criteria = null, $id_as_key = false)
    {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT * FROM ' . $this->db->prefix('myiframe');
        if (isset($criteria) && is_subclass_of($criteria, 'CriteriaElement')) {
            $sql .= ' ' . $criteria->renderWhere();
            if ('' !== $criteria->getSort()) {
                $sql .= ' ORDER BY ' . $criteria->getSort() . ' ' . $criteria->getOrder();
            }
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        $result = $this->db->query($sql, $limit, $start);
        if (!$result) {
            return $ret;
        }
        while (false !== ($myrow = $this->db->fetchArray($result))) {
            if (!$id_as_key) {
                $ret[] = new Myiframe($myrow);
            } else {
                $ret[$myrow['frame_frameid']] = new Myiframe($myrow);
            }
        }

        return $ret;
    }

    /**
     * @param null|CriteriaCompo $criteria
     * @return int
     */
    public function getCount(CriteriaCompo $criteria = null)
    {
        $sql = 'SELECT COUNT(*) FROM ' . $this->db->prefix('myiframe');
        if (isset($criteria) && is_subclass_of($criteria, 'CriteriaElement')) {
            $sql .= ' ' . $criteria->renderWhere();
        }
        $result = $this->db->query($sql);
        if (!$result) {
            return 0;
        }
        list($count) = $this->db->fetchRow($result);

        return $count;
    }

    /**
     * @param null|CriteriaCompo $criteria
     * @return bool
     */
    public function deleteAll(CriteriaCompo $criteria = null)
    {
        $sql = 'DELETE FROM ' . $this->db->prefix('myiframe');
        if (isset($criteria) && is_subclass_of($criteria, 'CriteriaElement')) {
            $sql .= ' ' . $criteria->renderWhere();
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }

        return true;
    }

    /**
     * @param $frame_id
     */
    public function updatehits($frame_id)
    {
        $sql = sprintf('UPDATE "%s" SET frame_hits = frame_hits+1 WHERE frame_frameid="%u"', $this->db->prefix('myiframe'), (int)$frame_id);
        $this->db->queryF($sql);
    }
}
