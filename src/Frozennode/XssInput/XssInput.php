<?php namespace Frozennode\XssInput;

class XssInput extends \Illuminate\Support\Facades\Input {

    /**
     * Get an item from the input data.
     *
     * This method is used for all request verbs (GET, POST, PUT, and DELETE)
     *
     * @param null $key
     * @param null $default
     * @param null $cleanse
     * @return mixed|string
     */
    public static function get($key = null, $default = null, $cleanse = null)
    {
        $value = static::$app['request']->input($key, $default);
        $global_cleanse = static::$app['config']->get('xssinput::xssinput.xss_filter_all_inputs');

        if ( $cleanse === true || ($cleanse === NULL && $global_cleanse) )
        {
            $value = Security::xss_clean($value);
        }


        return $value;
    }

    /**
     * Get all of the input and files for the request.
     *
     * @param  bool		$cleanse
     *
     * @return array
     */
    public static function all($cleanse = null)
    {
        $all = static::$app['request']->all();
        $global_cleanse = static::$app['config']->get('xssinput::xssinput.xss_filter_all_inputs');

        if ( $cleanse === true || ($cleanse === NULL && $global_cleanse) )
        {
            foreach ($all as &$value)
            {
                $value = Security::xss_clean($value);
            }
        }

        return $all;
    }

    /**
     * Get all of the input and files for the request and except specified inputs.
     *
     * @param $keys
     * @param null $cleanse
     * @return mixed
     */
    public static function except($keys, $cleanse = null)
    {
        $except = static::$app['request']->except($keys);

        $global_cleanse = static::$app['config']->get('xssinput::xssinput.xss_filter_all_inputs');

        if ( $cleanse === true || ($cleanse === NULL && $global_cleanse) )
        {
            foreach ($except as &$value)
            {
                $value = Security::xss_clean($value);
            }
        }

        return $except;
    }

    /**
     * Get only specified fields of the input and files for the request.
     *
     * @param $keys
     * @param null $cleanse
     * @return mixed
     */
    public static function only($keys, $cleanse = null)
    {
        $only = static::$app['request']->only($keys);

        $global_cleanse = static::$app['config']->get('xssinput::xssinput.xss_filter_all_inputs');

        if ( $cleanse === true || ($cleanse === NULL && $global_cleanse) )
        {
            foreach ($only as &$value)
            {
                $value = Security::xss_clean($value);
            }
        }

        return $only;
    }
}