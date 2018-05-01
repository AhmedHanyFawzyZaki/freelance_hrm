<?php

/*
 * 
 * 
 * sample useage
 * 
 * $this->widget('application.extensions.floara.Floara', array(
 *               'model'=>$model,
 *               'attribute' => 'attr'
 *               ));
 *  http://editor.froala.com/docs/options
 */

class Floara extends CInputWidget {

    private $_config = array();
    public $basicConfig = array();

    public function init() {
        $this->basicConfig = array(
            'inlineMode' => false,
            'imageUploadURL' => Yii::app()->baseUrl . '/floara/upload'
        );
        parent::init();
    }

    // Takes in configuration data from widget declaration and overrides any default settings
    public function setConfig($value) {
        if (is_array($value) && count($value) > 0) {
            foreach ($value as $key => $value) {
                $this->_config[$key] = $value;
            }
        }
    }

    public function run() {
        parent::run();

        list($name, $id) = $this->resolveNameID();

        // Publish assets to public directory
        $baseDir = dirname(__FILE__);
        $assets = Yii::app()->getAssetManager()->publish($baseDir . DIRECTORY_SEPARATOR . 'assets');
        $cs = Yii::app()->getClientScript();
        $cs->registerScriptFile($assets . '/js/froala_editor.min.js');
        $cs->registerCssFile($assets . '/css/froala_editor.min.css');
        $cs->registerCssFile($assets . '/css/font-awesome.min.css');

        echo CHtml::activeTextArea($this->model, $this->attribute, array('rows' => 10, 'cols' => 70));

        $this->replace($id, $this->_config);
    }

    public function replace($id, $config = array()) {

        $_config = array_merge($this->basicConfig, $config);
        $js = "";
        $out = "";
        if (!empty($_config)) {
            $js .= "$(function(){ $('#{$id}').editable({$this->jsEncode($_config)}); });";
        } else {
            $js .= "$(function(){ $('#{$id}').editable(); });";
        }

        //update the textarea before submition
        $js .= "$('#{$id}').parents('form:first').submit(function(){ $('#{$id}').html($('#{$id}').editable('getHTML')); return true; })";

        $out .= $this->script($js);


        print $out;
        $out = "";

        return $out;
    }

    private function script($js) {
        $out = "<script type=\"text/javascript\">";
        $out .= "//<![CDATA[\n";
        $out .= $js;
        $out .= "\n//]]>";
        $out .= "</script>\n";

        return $out;
    }

    private function jsEncode($val) {
        if (is_null($val)) {
            return 'null';
        }
        if (is_bool($val)) {
            return $val ? 'true' : 'false';
        }
        if (is_int($val)) {
            return $val;
        }
        if (is_float($val)) {
            return str_replace(',', '.', $val);
        }
        if (is_array($val) || is_object($val)) {
            if (is_array($val) && (array_keys($val) === range(0, count($val) - 1))) {
                return '[' . implode(',', array_map(array($this, 'jsEncode'), $val)) . ']';
            }
            $temp = array();
            foreach ($val as $k => $v) {
                $temp[] = $this->jsEncode("{$k}") . ':' . $this->jsEncode($v);
            }
            return '{' . implode(',', $temp) . '}';
        }
        if (strpos($val, '@@') === 0)
            return substr($val, 2);
        return '"' . str_replace(array("\\", "/", "\n", "\t", "\r", "\x08", "\x0c", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'), $val) . '"';
    }

}

?>
