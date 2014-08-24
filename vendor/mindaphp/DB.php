<?php
namespace MindaPHP;

class DBError extends \Exception {};

class DB
{
  public static $host=null;
  public static $username=null;
  public static $password=null;
  public static $database=null;
  public static $port=null;
  public static $socket=null;
  public static $error=null;
  
  protected static $mysqli = null;
  
  protected static function connect()
  {
    if (class_exists('Router',false) && Router::getPhase()!='action') {
      static::error('Database can only be used in MindaPHP action');
    }
    if (!static::$mysqli) {
      $reflect = new \ReflectionClass('mysqli');
      $args = array(static::$host,static::$username,static::$password,static::$database,static::$port,static::$socket);
      while (isset($args[count($args)-1]) && $args[count($args)-1] !== null) array_pop($args);
      static::$mysqli = $reflect->newInstanceArgs($args);
      if (mysqli_connect_errno()) static::error(mysqli_connect_error());
    }
  }
    
  protected static function error($message)
  {
  	throw new DBError($message);
  }
   
  public static function selectValue($query)
  {
    $record = forward_static_call_array('DB::selectOne', func_get_args());
    if (!is_array($record)) return false;
    $firstTable = array_shift($record);
    if (!is_array($firstTable)) return false;
    return array_shift($firstTable);
  }

  
  public static function selectValues($query)
  {
    $result = forward_static_call_array('DB::select', func_get_args());
    if (!is_array($result)) return false;
    $list = array();
    foreach ($result as $record) {
      if (!is_array($record)) return false;
      $firstTable = array_shift($record);
      if (!is_array($firstTable)) return false;
      $list[] = array_shift($firstTable);
    }
    return $list;
  }
  
  public static function selectPairs($query)
  {
    $result = forward_static_call_array('DB::select', func_get_args());
    if (!is_array($result)) return false;
    $list = array();
    foreach ($result as $record) {
      $firstTable = array_shift($record);
      $list[array_shift($firstTable)] = array_shift($firstTable);
    }
    return $list;
  }
    
  public static function selectOne($query)
  {
    $args = func_get_args();
    if (func_num_args() > 1) {
      array_splice($args,1,0,array(str_repeat('s', count($args)-1)));
    }
    return forward_static_call_array('DB::selectOneTyped', $args);
  }
    
  private static function selectOneTyped($query)
  {
    $result = forward_static_call_array('DB::selectTyped', func_get_args());
    if (!is_array($result)) return false;
    if (isset($result[0])) return $result[0];
    return $result;
  }
    
  public static function select($query)
  {
    $args = func_get_args();
    if (func_num_args() > 1) {
      array_splice($args,1,0,array(str_repeat('s', count($args)-1)));
    }
    $result = forward_static_call_array('DB::selectTyped', $args);
    if (!is_array($result)) return false;
    return $result;
  }
   
  private static function selectTyped($query)
  {
    if (!Debugger::$enabled) {
      try {
        static::$error = false;
        return forward_static_call_array('DB::selectTypedInternal', func_get_args());
      } catch (DBError $e) {
        static::$error = $e->getMessage();
        return false;
      }
    }
    $time = microtime(true);
    $result = forward_static_call_array('DB::selectTypedInternal', func_get_args());
    $duration = microtime(true)-$time;
    $arguments = func_get_args();
    if (strtoupper(substr(trim($query), 0, 6))=='SELECT') {
      $arguments[0] = 'explain '.$query;
      $explain = forward_static_call_array('DB::selectTypedInternal', $arguments);
    } else {
      $explain = false;
    }
    $arguments = array_slice(func_get_args(),2);
    $equery = static::$mysqli->real_escape_string($query);
    Debugger::add('queries',compact('duration','query','equery','arguments','result','explain'));
    return $result;
  }
    
  private static function selectTypedInternal($query)
  {
    static::connect();
    $query = static::$mysqli->prepare($query);
    if (!$query) {
      return static::error(static::$mysqli->error);
    }
    if (func_num_args() > 1) {
      $args = array_slice(func_get_args(), 1);
      foreach (array_keys($args) as $i) {
        if ($i>0) $args[$i] = & $args[$i];
      }
      call_user_func_array(array($query, 'bind_param'),$args);
    }
    $query->execute();
    if ($query->errno) {
      return static::error(static::$mysqli->error);
    }
    if ($query->affected_rows > -1) {
      return $query->affected_rows;
    }
    $params = array();
    $meta = $query->result_metadata();
    while ($field = $meta->fetch_field()) {
      if (!$field->table && strpos($field->name, '.')) {
        $parts = explode('.', $field->name, 2);
        $params[] = &$row[$parts[0]][$parts[1]];
      } else {
        if (!isset($row[$field->table])) $row[$field->table] = array();
        $params[] = &$row[$field->table][$field->name];
      }
    }
    call_user_func_array(array($query, 'bind_result'), $params);

    $result = array();
    while ($query->fetch()) {
      $result[] = json_decode(json_encode($row),true);
    }

    $query->close(); 

    return $result;
  }
 
  public static function insert($query)
  {
    $args = func_get_args();
    if (func_num_args() > 1) {
      array_splice($args,1,0,array(str_repeat('s', count($args)-1)));
    }
    $result = forward_static_call_array('DB::selectTyped', $args);
    if (!is_int($result)) return false;
    if (!$result) return false;
    return static::$mysqli->insert_id;
  }
  
  public static function update($query)
  {
    $args = func_get_args();
    if (func_num_args() > 1) {
      array_splice($args,1,0,array(str_repeat('s', count($args)-1)));
    }
    $result = forward_static_call_array('DB::selectTyped', $args);
    if (!is_int($result)) return false;
    return $result;
  }
  
  public static function delete($query)
  {
    return forward_static_call_array('DB::update', func_get_args());
  }
    
  // Undocumented
  public static function handle()
  {
    static::connect();
    return static::$mysqli;
  }
  
  // Undocumented
  public static function options()
  {
    return call_user_func_array(array(static::$mysqli, 'options'), func_get_args());
  }
   
  // Undocumented
  public static function close()
  {
    return static::$mysqli->close();
  }

}