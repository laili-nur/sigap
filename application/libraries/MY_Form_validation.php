<?php
/** application/libraries/MY_Form_validation **/
class MY_Form_validation extends CI_Form_validation
{
    public $CI;

    public function __construct($config = array())
    {
        parent::__construct($config);
    }

    /**
     * Add error
     *
     * Adds a custom error to the form validation array
     *
     * @return  array
     */
    public function add_to_error_array($field = '', $message = '')
    {
        if (!isset($this->_error_array[$field])) {
            $this->_error_array[$field] = $message;
        }

        return;
    }

    /**
     * Error Array
     *
     * Returns the error messages as an array
     *
     * @return  array
     */
    public function error_array()
    {
        if (count($this->_error_array) === 0) {
            return false;
        } else {
            return $this->_error_array;
        }

    }
}