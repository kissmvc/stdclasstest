<?php
/**
 * stdClass speed test for KISS Framework.
 *
 * @url			https://github.com/kissmvc/kissmvc
 * @package		KISS Framework
 * @author		Anton Piták, SOFTPAE.com
 * @link		http://www.softpae.com
 *
 */

//ini_set('memory_limit', '512M');

// default required implementation
class stdObject1 {
	
	protected $values = array(); //Simplify the code 
	
	function __set($id, $value) {
		$this->values[$id] = $value;
	}
	
	function &__get($id) { 
		if (is_callable($this->values[$id])) {
			return $this->values[$id]($this);
		} else {
			if(array_key_exists($id, $this->values)) {
				return $this->values[$id];
			}
			return null;
		}
	}

	public function __isset($name) { 
		return isset($this->values[$name]);
	} 
 
    public function  __unset($name) {
        unset($this->values[$name]);
    }
	
	public function __call($key, $args) {
	
		$arg_data = array();
		
		$args = func_get_args();
		
		foreach ($args as $arg) {
			if ($arg instanceof Ref) {
				$arg_data[] =& $arg->getRef();
			} else {
				$arg_data[] =& $arg;
			}
		}
		
		if (isset($this->values[$key])) {		
			return call_user_func_array($this->values[$key], $arg_data);	
		} else {
			//$trace = debug_backtrace();
			exit('<b>Notice</b>:  Undefined property: Proxy::' . $key . ' in <b>' . $trace[1]['file'] . '</b> on line <b>' . $trace[1]['line'] . '</b>');
		}
	}

}

// KISS Framework stdClass extended object!!!
class stdObject2 extends stdClass implements ArrayAccess, Iterator { // Traversable

	private $_default = array();

	public function __call($closure, $args) {
		if (isset($this->{$closure}) && is_callable($this->{$closure})) {
			return call_user_func_array($this->{$closure}, $args);
        } else {
			return call_user_func_array($this->{$closure}->bindTo($this), $args);
        }
	}

	public function __toString() {
		return call_user_func($this->{"__toString"}->bindTo($this));
	}
	
	public function __invoke() {
		$args = func_get_args();
		if (isset($args[0]) && isset($this->{$args[0]})) {
			return $this->{$args[0]};
		}
		//throw new Exception("Fatal error: Call to undefined method stdObject::{$args[0]}()");
		return null;
	}
	
	public function setDefault(&$value) {
		if (is_array($value)) {
			$this->_default = $value;
		} else {
			$this->_default = array($value);
		}
	}
	
	/* AccessArray methods */
	
	public function offsetSet($offset, $value) {
		$this->{$offset} = $value;
    }
	
    public function offsetExists($offset) {
        return isset($this->{$offset});
    }
	
    public function offsetUnset($offset) {
        unset($this->{$offset});
    }
	
    public function offsetGet($offset) {
        return isset($this->{$offset}) ? $this->{$offset} : null;
    }
	
	/* Iterator methods */
 
    public function rewind() {
        reset($this->_default);
    }
 
    public function valid() {
		return key($this->_default) !== null;
    }
 
    public function key() {
        return key($this->_default);
    }
 
    public function current() {
        return current($this->_default);
    }
 
    public function next() {
        next($this->_default);
    }
	
}

// simple implementation
class stdObject3 {

    public $data = array();

    public function  &__get($name) {

        if(array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
        return null;
    }
 
    public function  __set($name, $value) {
        $this->data[$name] = $value;
    }
 
    public function  __isset($name) {
        return array_key_exists($name, $this->data);
    }
 
    public function  __unset($name) {
        unset($this->data[$name]);
    }
	
	public function __call($key, $args) {
		return call_user_func_array($this->{$key}, $args);
	}

}

// absolutely clean implementation
class stdObject4 {

    public function  &__get($name) {

    }
 
    public function  __set($name, $value) {

    }
 
    public function  __isset($name) {

    }
 
    public function  __unset($name) {

    }
	
	public function __call($key, $args) {

	}

}


echo 'stdObject test<br>'.PHP_EOL;

$start = microtime(true);

$obj = new stdObject1();

$obj->test = function($p) { return $p; };

for ($i = 0; $i < 300000; $i++) {
	//$obj->name = $i;								//integer test
	//$obj->ID = '1';								//string test
	//$obj->arr = array('');						//array test
	$obj->test($i);									//closure test
}
echo 'Memory: '.(memory_get_usage(true)/1048576).' MB<br>'.PHP_EOL;
echo 'Memory Peak: '.(memory_get_peak_usage(true)/1048576).' MB<br>'.PHP_EOL;
echo 'Time: '.(microtime(true)-$start).'<br>'.PHP_EOL;

unset($obj);

echo '<br>'.PHP_EOL;
echo 'stdObject2 test<br>'.PHP_EOL;

$start = microtime(true);

$obj = new stdObject2();

$obj->test = function($p) { return $p; };

for ($i = 0; $i < 300000; $i++) {
	//$obj->name = $i;
	//$obj->ID = '1';
	//$obj->arr = array('');
	$obj->test($i);
}
echo 'Memory: '.(memory_get_usage(true)/1048576).' MB<br>'.PHP_EOL;
echo 'Memory Peak: '.(memory_get_peak_usage(true)/1048576).' MB<br>'.PHP_EOL;
echo 'Time: '.(microtime(true)-$start).'<br>'.PHP_EOL;

unset($obj);

echo '<br>'.PHP_EOL;
echo 'stdObject3 test<br>'.PHP_EOL;

$start = microtime(true);

$obj = new stdObject3();

$obj->test = function($p) { return $p; };

for ($i = 0; $i < 300000; $i++) {
	//$obj->name = $i;
	//$obj->ID = '1';
	//$obj->arr = array('');
	$obj->test($i);
}
echo 'Memory: '.(memory_get_usage(true)/1048576).' MB<br>'.PHP_EOL;
echo 'Memory Peak: '.(memory_get_peak_usage(true)/1048576).' MB<br>'.PHP_EOL;
echo 'Time: '.(microtime(true)-$start).'<br>'.PHP_EOL;

unset($obj);

echo '<br>'.PHP_EOL;
echo 'stdObject4 test<br>'.PHP_EOL;

$start = microtime(true);

$obj = new stdObject4();

$obj->test = function($p) { return $p; };

for ($i = 0; $i < 300000; $i++) {
	//$obj->name = $i;
	//$obj->ID = '1';
	//$obj->arr = array('');
	$obj->test($i);
}
echo 'Memory: '.(memory_get_usage(true)/1048576).' MB<br>'.PHP_EOL;
echo 'Memory Peak: '.(memory_get_peak_usage(true)/1048576).' MB<br>'.PHP_EOL;
echo 'Time: '.(microtime(true)-$start).'<br>'.PHP_EOL;

unset($obj);

echo '<br>'.PHP_EOL;
echo 'stdClass test<br>'.PHP_EOL;

$start = microtime(true);

$obj = new stdClass;

for ($i = 0; $i < 300000; $i++) {
	$obj->name = $i;
	//$obj->ID = '1';
	//$obj->arr = array('');
}
echo 'Memory: '.(memory_get_usage(true)/1048576).' MB<br>'.PHP_EOL;
echo 'Memory Peak: '.(memory_get_peak_usage(true)/1048576).' MB<br>'.PHP_EOL;
echo 'Time: '.(microtime(true)-$start).'<br>'.PHP_EOL;

unset($obj);

echo '<br>'.PHP_EOL;
echo 'Array test<br>'.PHP_EOL;

$start = microtime(true);

$obj = array();

$obj['test'] = function($p) { return $p; };

for ($i = 0; $i < 300000; $i++) {
	//$obj['name'] = $i;
	//$obj['ID'] = '1';
	//$obj['arr'] = array('');
	$obj['test']($i);
}
echo 'Memory: '.(memory_get_usage(true)/1048576).' MB<br>'.PHP_EOL;
echo 'Memory Peak: '.(memory_get_peak_usage(true)/1048576).' MB<br>'.PHP_EOL;
echo 'Time: '.(microtime(true)-$start).'<br>'.PHP_EOL;

unset($obj);


