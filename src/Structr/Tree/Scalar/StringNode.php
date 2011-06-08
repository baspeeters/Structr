<?php

namespace Structr\Tree\Scalar;

use Structr\Tree\Base\ScalarNode;

class StringNode extends ScalarNode {
	protected $regexp = null;

	public function getScalarType() {
		return "string";
	}

	public function regexp($regexp) {
		$this->regexp = $regexp;
		
		return $this;
	}

	protected function coerceValueFromObject($value, $strict) {
		if(is_callable(array($value, "__toString"))) {
			return (string)$value;
		}

		if($strict) {
			throw new \Structr\Exceptions\CannotCoerceException("Cannot coerce an object to a string in strict mode");
		}

		return "Object";
	}

	public function value($parentValue = null) {
		$value = parent::value($parentValue);

		if($this->regexp !== null && !preg_match($this->regexp, $value)) {
			throw new \Structr\Exceptions\NoRegexpMatchException("String did not match regular expression");
		}

		return $value;
	}
}