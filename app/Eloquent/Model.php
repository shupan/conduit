<?php

namespace app\Eloquent;

use App\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * 封装对Model的操作
 * @package app\Eloquent
 */
class Model extends BaseModel
{

    /**
     * 执行查询的SQL
     * @param $sql
     * @param array $bindings
     * @param null $connection
     * @return Collection
     * @todo  这里存在多次setConnection的情况
     */
    public static function querySql($sql, $bindings = [], $connection = null)
    {
        $instance = (new static)->setConnection($connection);

        $items = $instance->getConnection()->select($sql, $bindings);

        return $items;
        //return static::hydrate($items, $connection);
    }

    public static function queryRow($sql, $bindings = [], $connection = null){
        $instance = (new static)->setConnection($connection);

        $items = $instance->getConnection()->selectOne($sql, $bindings);

        return $items;
        //return static::hydrate($items, $connection);
    }



    public function newCollection(array $models = [])
    {
        return new Collection($models);
    }

    /**
     * Create a collection of model objects and return the instance.
     *
     * @param array $elements
     *
     * @return Collection
     */
    public static function createMany(array $elements)
    {
        if (!count($elements)) {
            return new Collection();
        }
        $models = [];
        foreach ($elements as $attributes) {
            $models[] = static::create($attributes);
        }

        return new Collection($models);
    }

    /**
     * Create a new basic model object and return the instance.
     *
     * @param array $attributes
     *
     * @return Model
     */
    public static function createModel(array $attributes)
    {
        return new static($attributes);
    }

    /**
     * Create a new basic model object and return the instance.
     *
     * @param array $attributes
     *
     * @return Model
     */
    public static function createModels(array $elements)
    {
        $models = [];
        foreach ($elements as $attributes) {
            $models[] = new static($attributes);
        }

        return $models;
    }

    public function scopeOfUser($query, $type)
    {
        return $query->whereUserId($type);
    }

    public function scopeAuth($query)
    {
        return $query->whereUserId(\Auth::user()->id);
    }

    /*************************************************************
     *        新使用的Model SQL
     *************************************************************
     *1. 支持自定义SQL查询
     *2. 支持单条SQL的查询
     *3. 支持批量的插入和更新的操作
     *
     * @date 2016-09-11
     *************************************************************/



    /**
     * 查询数据
     * @param array $fields 查询字段
     * @param array $filter 查询条件
     * @param array $order 排序条件
     * @param int $limit 查询数量
     * @param int $offset 偏移量
     * @return array
     *
     * @todo 是否能够把user_id或者account_id 能够自动传递？
     */
    public static function query(array $fields = null, array $filter = null, array $order = null, $limit = 0, $offset = 0 , $connection = null)
    {
        $instance = (new static)->setConnection($connection);
        $table = $instance->getTable();
        $fields = empty($fields) ? '*' : implode(',', $fields);
        $sql = "SELECT {$fields} FROM {$table}";
        if (!empty($filter)) {
            $sql .= " WHERE " . self::parseFilter($filter);
        }
        if (!empty($order)) {
            $orderSql = array();
            foreach ($order as $key => $val) {
                $orderSql[] = "{$key} " . (strtolower($val) == 'asc' ? 'ASC' : 'DESC');
            }
            $sql .= " ORDER BY " . implode(', ', $orderSql);
        }
        if ($limit > 0) $sql .= $offset > 0 ? " LIMIT $offset, $limit" : " LIMIT $limit";
        return self::querySql($sql,[],$connection);
    }

    public static function queryByAuth(array $fields = null, array $filter = null, array $order = null, $limit = 0, $offset = 0 , $connection = null)
    {
        $filter['user_id'] = \Auth()->id();
        return self::query( $fields, $filter,  $order, $limit , $offset , $connection);
    }

    /**
     * 查询一行记录
     *
     * @param array $filter 过滤条件
     * @param array $fields 字段
     * @return array
     */
    public static function queryOne(array $fields = array(),array $filter = null, $connection = null)
    {
        $instance = (new static)->setConnection($connection);
        if ($fields) {
            $fields = '`' . implode('`,`', $fields) . '`';
        } else {
            $fields = '*';
        }
        $sql = "SELECT {$fields} FROM " . $instance->getTable();
        if (!empty($filter)) {
            $sql .= " WHERE " . self::parseFilter($filter);
        }
        $sql .= " LIMIT 1";
        return self::queryRow($sql,[],$connection);
    }

    /**
     * 分页查询
     *
     * @param array $fields 查询字段
     * @param array $filter 查询条件
     * @param array $order 排序条件
     * @param int $page 页码
     * @param int $size 每页数量
     * @return array
     */
    public static function page(array $fields, array $filter, array $order, $page = 1, $size = 20)
    {
        $offset = 0;
        if ($page > 0 && $size > 0) {
            $page = max(intval($page), 1);
            $size = max(intval($size), 1);
            $offset = ($page - 1) * $size;
        }
        return self::query($fields, $filter, $order, $size, $offset);
    }

    /**
     * 表统计
     *
     * @param array $filter
     * @return int
     */
    public static function count(array $filter = array() , $connection = null)
    {
        $instance = (new static)->setConnection($connection);
        $sql = "SELECT COUNT(*) as count FROM " . $instance->getTable();
        if (!empty($filter)) $sql .= " WHERE " . self::parseFilter($filter);
        $row = self::queryRow($sql,[],$connection);
        return intval($row->count);
    }

    /**
     * 插入或更新
     *
     * 当主键或唯一索引不存在时，进行插入，当出现主键或唯一索引冲突时，则进行更新。
     * 返回值说明：
     *   返回影响的记录数，如果是新插入的数据，则+1，如果是更新数据，则+2，如果数据没有发生变化，则为0。
     *   因此，当对单条记录进行插入或更新时，可以根据返回值判断，数据是更新还是插入，还是不变。
     *   当进行批量操作时，返回值只能表示有没数据被插入或更新，并不能表示具体插入或更新了多少行。
     *
     * @param array $data 要插入的数据
     * @param bool|false $multi 是否批量操作
     * @return int 影响记录数
     */
    public static function insertOrUpdate(array $data, $multi = false, $connection = null)
    {
        $instance = (new static)->setConnection($connection);
        if (empty($data)) return 0;
        if (!$multi) $data = array($data);
        $table = $instance->getTable();
        $fields = '`' . implode('`,`', array_keys($data[0])) . '`'; //字段
        // 插入值列表
        $values = [];
        foreach ($data as $row) {
            $values[] = implode(',', array_map("self::quote", array_values($row)));
        }
        $values = '(' . implode('),(', $values) . ')';
        // 更新列表
        foreach (array_keys($data[0]) as $field) {
            $updates[] = "`{$field}`=VALUES(`{$field}`)";
        }
        $updates = implode(',', $updates);

        $sql = "INSERT INTO {$table} ({$fields}) VALUES {$values} ON DUPLICATE KEY UPDATE {$updates}";
        //return $this->db->execute($sql);
        return self::querySql($sql,[],$connection);
    }



    /**
     * 将数组解析成SQL
     *
     * filter 语法说明:
     *  $filter['foo__gt'] = 10，解析后的SQL为 foo > 10
     *  $filter['foo__gte'] = 10，解析后的SQL为 foo >= 10
     *  $filter['foo__lt'] = 10, 解析后的SQL为 foo < 10
     *  $filter['foo__between'] = [1, 10], 解析后的SQL为 foo between 1 AND 10
     *  $filter['foo_in'] = [1,2,3,4]，解析后的SQL为 foo IN (1,2,3,4)
     *  ...
     *
     * @param array $filter
     * @return string
     */
    protected static function parseFilter(array $filter)
    {
        $where = array();
        foreach ($filter as $field => $val) {
            if (($pos = strrpos($field, '__')) > 0) {
                $op = substr($field, $pos + 2);
                $field = substr($field, 0, $pos);
                switch ($op) {
                    case 'gt': //大于
                        $where[] = "`{$field}` > " . self::quote($val);
                        break;
                    case 'gte': //大于等于
                        $where[] = "`{$field}` >= " . self::quote($val);
                        break;
                    case 'lt': //小于
                        $where[] = "`{$field}` < " . self::quote($val);
                        break;
                    case 'lte': //小于等于
                        $where[] = "`{$field}` <= " . self::quote($val);
                        break;
                    case 'ne': //不等于
                        $where[] = "`{$field}` != " . self::quote($val);
                        break;
                    case 'like': //LIKE ‘%%’
                        $where[] = "`{$field}` LIKE " . self::quote("%{$val}%");
                        break;
                    case 'startswith': //LIKE 'xxx%'
                        $where[] = "`{$field}` LIKE " . self::quote("{$val}%");
                        break;
                    case 'endswith': //LIKE '%xxx'
                        $where[] = "`{$field}` LIKE " . self::quote("%{$val}");
                        break;
                    case 'between': //between 'a' AND 'b'
                        $where[] = "`{$field}` BETWEEN " . self::quote($val[0]) . " AND " . self::quote($val[1]);
                        break;
                    case 'in': // IN (1,2,3)
                        if (!is_array($val)) $val = array($val);
                        foreach ($val as $k => $v) {
                            $val[$k] = self::quote($v);
                        }
                        $where[] = "`{$field}` IN (" . implode(',', $val) . ")";
                        break;
                    case 'notin': // NOT IN (1,2,3)
                        if (!is_array($val)) $val = array($val);
                        foreach ($val as $k => $v) {
                            $val[$k] = self::quote($v);
                        }
                        $where[] = "`{$field}` NOT IN (" . implode(',', $val) . ")";
                        break;
                    case 'isnull':
                        if ($val) {
                            $where[] = "`{$field}` IS NULL";
                        } else {
                            $where[] = "`{$field}` IS NOT NULL";
                        }
                        break;
                }
            } elseif (is_array($val)) {
                foreach ($val as $k => $v) {
                    $val[$k] = self::quote($v);
                }
                $where[] = "`{$field}` IN (" . implode(',', $val) . ")";
            } else {
                $where[] = "`{$field}` = " . self::quote($val);
            }
        }
        return implode(' AND ', $where);
    }

    /**
     * 给值加引号
     * @param $value
     * @return string
     */
    public static function quote($value){
        // return  $this->getConnection()->quote($value);
        return "'$value'";
    }
    
}
