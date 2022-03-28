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
 * Class MyiframeBaseHandler
 */
class MyiframeBaseHandler extends \XoopsObjectHandler
{
    /**
     * @param bool $isNew
     * @return \XoopsModules\Myiframe\MyiframeBase
     */
    public function create($isNew = true)
    {
        $object = new MyiframeBase();
        if ($isNew) {
            $object->setNew();
        }

        return $object;
    }

    /**
     * @param int $id
     * @return \XoopsModules\Myiframe\MyiframeBase|null
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
            $object = new MyiframeBase();
            $object->assignVars($this->db->fetchArray($result));

            return $object;
        }

        return $ret;
    }

    /**
     * @param bool $force
     * @return bool
     */
    public function insert(\XoopsObject $object, $force = false)
    {
        if (!$object instanceof MyiframeBase) {
            return false;
        }
        if (!$object->isDirty()) {
            return true;
        }
        if (!$object->cleanVars()) {
            foreach ($object->getErrors() as $oneerror) {
                \trigger_error($oneerror);
            }

            return false;
        }
        foreach ($object->cleanVars as $k => $v) {
            ${$k} = $v;
        }

        if ($object->isNew()) {
            $format = 'INSERT INTO %s (frame_created, frame_uid, frame_description, frame_width, frame_height, frame_align, frame_frameborder, frame_marginwidth, frame_marginheight, frame_scrolling, frame_hits, frame_url) VALUES (%u, %u, %s, %s, %s, %d, %d, %d, %d, %d, %u, %s)';
            $sql    = \sprintf(
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
            $format = 'UPDATE %s SET frame_description=%s, frame_width=%s, frame_height=%s, frame_align="%d", frame_frameborder="%d", frame_marginwidth="%d", frame_marginheight="%d", frame_scrolling="%d", frame_hits="%u", frame_url=%s WHERE frame_frameid=%u';
            $sql    = \sprintf(
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
     * @param bool $force
     * @return bool
     */
    public function delete(\XoopsObject $object, $force = false)
    {
        if (!$object instanceof MyiframeBase) {
            return false;
        }
        $sql = \sprintf('DELETE FROM %s WHERE frame_frameid = "%u"', $this->db->prefix('myiframe'), $object->getVar('frame_frameid'));
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
     * @param \Criteria|null $criteria
     * @param bool           $id_as_key
     * @return array
     */
    public function &getObjects(\Criteria $criteria = null, $id_as_key = false): array
    {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT * FROM ' . $this->db->prefix('myiframe');
        if (($criteria instanceof \CriteriaCompo) || ($criteria instanceof \Criteria)) {
            $sql .= ' ' . $criteria->renderWhere();
            if ('' !== $criteria->getSort()) {
                $sql .= ' ORDER BY ' . $criteria->getSort() . ' ' . $criteria->getOrder();
            }
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        $result = $this->db->query($sql, $limit, $start);
        /** @var array $myrow */
        if ($result instanceof \mysqli_result) {

            while (false !== ($myrow = $this->db->fetchArray($result))) {
                if (!$id_as_key) {
                    $ret[] = new MyiframeBase($myrow);
                } else {
                    $ret[$myrow['frame_frameid']] = new MyiframeBase($myrow);
                }
            }
        }

        return $ret;
    }

    /**
     * @param \CriteriaCompo|null $criteria
     * @return int
     */
    public function getCount(\CriteriaCompo $criteria = null): int
    {
        $sql = 'SELECT COUNT(*) FROM ' . $this->db->prefix('myiframe');
        if (($criteria instanceof \CriteriaCompo) || ($criteria instanceof \Criteria)) {
            $sql .= ' ' . $criteria->renderWhere();
        }
        $result = $this->db->query($sql);
        if (!$result) {
            return 0;
        }
        [$count] = $this->db->fetchRow($result);

        return $count;
    }

    /**
     * @param \CriteriaCompo|null $criteria
     * @return bool
     */
    public function deleteAll(\CriteriaCompo $criteria = null): bool
    {
        $sql = 'DELETE FROM ' . $this->db->prefix('myiframe');
        if (($criteria instanceof \CriteriaCompo) || ($criteria instanceof \Criteria)) {
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
    public function updatehits($frame_id): void
    {
        $sql = \sprintf('UPDATE %s SET frame_hits = frame_hits+1 WHERE frame_frameid="%u"', $this->db->prefix('myiframe'), (int)$frame_id);
        $this->db->queryF($sql);
    }
}
