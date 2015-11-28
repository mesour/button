<?php
/**
 * This file is part of the Mesour Button (http://components.mesour.com/component/button)
 *
 * Copyright (c) 2015 Matouš Němec (http://mesour.com)
 *
 * For full licence and copyright please view the file licence.md in root of this project
 */

namespace Mesour\UI;

use Mesour\Components;

/**
 * @author Matouš Němec <matous.nemec@mesour.com>
 */
class Button extends Control
{

    const WRAPPER = 'wrapper',
        DEFAULTS = 'defaults',
        RIGHT_ICON = 'right_icon',
        ICON = 'icon';

    /**
     * @var Components\Html
     */
    private $wrapper;

    /**
     * @var Components\Html
     */
    private $left_icon;

    /**
     * @var Components\Html
     */
    private $right_icon;

    private $text = '';

    private $disabled = FALSE;

    private $translated_args = array('title', 'value', 'data-confirm', 'data-title');

    protected $option = array();

    public $onRender = array();

    static public $defaults = array(
        self::WRAPPER => array(
            'el' => 'a',
            'attributes' => array(
                'class' => 'btn btn-{_BTN_type_} {_BTN_size_} {_BTN_own_class_}',
                'role' => 'button',
            )
        ),
        self::ICON => array(
            'el' => 'span',
            'attributes' => array(
                'class' => 'glyphicon glyphicon-{_ICON_name_}'
            )
        ),
        self::RIGHT_ICON => array(
            'el' => 'span',
            'attributes' => array(
                'class' => 'glyphicon glyphicon-{_RICON_name_}'
            )
        ),
        self::DEFAULTS => array(
            '_BTN_type_' => 'default',
            '_BTN_own_class_' => '',
            '_BTN_size_' => '',
            '_ICON_name_' => 'pencil',
            '_RICON_name_' => 'pencil',
        )
    );

    public function __construct($name = NULL, Components\IContainer $parent = NULL)
    {
        parent::__construct($name, $parent);
        $this->option = self::$defaults;
    }

    /**
     * @return Components\Html
     */
    public function getControlPrototype()
    {
        return !$this->wrapper ? ($this->wrapper = Components\Html::el($this->option[self::WRAPPER]['el'])) : $this->wrapper;
    }

    public function setClassName($class_name, $append = FALSE)
    {
        $class = '';
        if ($append) {
            $class .= $this->option[self::DEFAULTS]['_BTN_own_class_'] . ' ';
        }
        $class .= $class_name;
        $this->option[self::DEFAULTS]['_BTN_own_class_'] = $class;
        return $this;
    }

    public function setConfirm($message)
    {
        $this->setAttribute('onclick', 'return confirm(\'' . str_replace("'", "\\'", $this->getTranslator()->translate($message)) . '\');');
        return $this;
    }

    public function setText($text)
    {
        return $this->setHtml(htmlspecialchars($this->getTranslator()->translate($text)));
    }

    public function setHtml($html)
    {
        $this->text = $html;
        return $this;
    }

    public function setAttribute($key, $value, $append = FALSE, $translated = FALSE)
    {
        if ($translated) {
            $this->translated_args[] = $key;
        }
        $this->translated_args = array_unique($this->translated_args);
        if ($append) {
            $this->getControlPrototype()->{$key}($value, TRUE);
        } else {
            $this->getControlPrototype()->{$key}($value);
        }
        return $this;
    }

    public function getAttributes()
    {
        return $this->getControlPrototype()->attrs;
    }

    public function hasAttribute($key)
    {
        return isset($this->getControlPrototype()->attrs[$key]);
    }

    public function getAttribute($key)
    {
        if (!$this->hasAttribute($key)) {
            throw new Components\Exception('Attribute ' . $key . ' does not exist.');
        }
        return $this->getControlPrototype()->attrs[$key];
    }

    /**
     * @return Components\Html|null
     */
    public function getIconPrototype()
    {
        return !$this->left_icon instanceof Components\Html ? ($this->left_icon = Components\Html::el($this->option[self::ICON]['el'])) : $this->left_icon;
    }

    /**
     * @return Components\Html|null
     */
    public function getRightIconPrototype()
    {
        return !$this->right_icon instanceof Components\Html ? ($this->right_icon = Components\Html::el($this->option[self::ICON]['el'])) : $this->right_icon;
    }

    public function setSize($size_class)
    {
        $this->option[self::DEFAULTS]['_BTN_size_'] = $size_class;
        return $this;
    }

    public function setType($type)
    {
        $this->option[self::DEFAULTS]['_BTN_type_'] = $type;
        return $this;
    }

    public function setDisabled($disabled = TRUE)
    {
        $this->disabled = $disabled;
    }

    public function setIcon($name = NULL)
    {
        if (!is_null($name)) {
            $this->option[self::DEFAULTS]['_ICON_name_'] = $name;
        }
        $this->left_icon = TRUE;
        return $this;
    }

    public function setRightIcon($name = NULL)
    {
        if (!is_null($name)) {
            $this->option[self::DEFAULTS]['_RICON_name_'] = $name;
        }
        $this->right_icon = TRUE;
        return $this;
    }

    public function create($data = array())
    {
        parent::create();

        $option_data = $this->option[self::DEFAULTS];
        $wrapper = $this->getControlPrototype();
        $this->wrapper = clone $wrapper;
        if ($this->left_icon) {
            $left_icon = $this->getIconPrototype();
            $this->left_icon = clone $left_icon;
        }
        if ($this->right_icon) {
            $right_icon = $this->getIconPrototype();
            $this->right_icon = clone $right_icon;
        }

        $this->onRender($this, $data);

        foreach ($this->option[self::WRAPPER]['attributes'] as $key => $value) {
            if (!$this->wrapper->{$key} && $this->wrapper->{$key} !== FALSE) {
                $this->wrapper->{$key}(trim(Components\Helper::parseValue($value, $option_data)));
            }
        }

        $attrs = $this->wrapper->attrs;
        foreach ($attrs as $key => $value) {
            if (!$this->disabled && $value instanceof Components\Link\IUrl) {
                if ($this->getAuth()->isAllowed($value)) {
                    $value = $value->create($data);
                } else {
                    unset($this->wrapper->{$key}, $attrs[$key]);
                    $disabled = TRUE;
                    continue;
                }
            } elseif ($this->disabled && $value instanceof Components\Link\IUrl) {
                unset($this->wrapper->{$key}, $attrs[$key]);
                continue;
            }

            if (count($data) > 0) {
                $attrs[$key] = trim(Components\Helper::parseValue($value, $data));
            }
            if (in_array($key, $this->translated_args)) {
                $attrs[$key] = trim($this->getTranslator()->translate($attrs[$key]));
            }
        }
        if ($this->disabled || isset($disabled)) {
            unset($this->wrapper->onclick, $attrs['onclick']);
            $attrs['class'] = $attrs['class'] . ' disabled';
        }
        $this->wrapper->addAttributes($attrs);

        if (isset($left_icon)) {
            foreach ($this->option[self::ICON]['attributes'] as $key => $value) {
                if (!$this->left_icon->{$key}) {
                    $this->left_icon->{$key}(Components\Helper::parseValue($value, $option_data));
                }
            }
            $this->wrapper->add($this->left_icon);
            if (strlen($this->text) > 0) {
                $this->wrapper->add('&nbsp;');
            }
            $this->left_icon = $left_icon;
        }

        $this->wrapper->add($this->text);

        if (isset($right_icon)) {
            foreach ($this->option[self::RIGHT_ICON]['attributes'] as $key => $value) {
                if (!$this->right_icon->{$key}) {
                    $this->right_icon->{$key}(Components\Helper::parseValue($value, $option_data));
                }
            }
            if (strlen($this->text) > 0) {
                $this->wrapper->add('&nbsp;');
            }
            $this->wrapper->add($this->right_icon);
            $this->$right_icon = $right_icon;
        }
        $out = $this->wrapper;
        $this->wrapper = $wrapper;
        return $out;
    }

    public function render($data = array())
    {
        echo $this->create($data);
    }

}
