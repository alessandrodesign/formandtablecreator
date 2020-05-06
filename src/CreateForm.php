<?php
/**
 * Copyright (c) 2020. AlessandroDESIGN - Tecnologias.
 * Como Usar:
 *
 * $form = new CreateForm([
 *         'id' => 'save',
 *         'name' => 'save',
 *         'method' => 'POST',
 *         'class' => 'row'
 *     ]);
 *
 *     $arr = ['com certeza' => 'C', 'sim' => 'Y', 'não' => 'N','toda vida'=>'toda'];
 *
 *     echo $form
 *         ->input('in01', 'in01', 'in01', null, ['placeholder' => 'in01'])
 *         ->input('in02', 'in02', 'in02', null, null, true, 'file')
 *         ->textarea('in03', 'in03', 'in03', 'Teste', ['placeholder' => 'in03'])
 *         ->radio('in04', 'in04', 'in04', $arr, ['Y'])
 *         ->radio('in05', 'in05', 'in05', $arr, ['N', 'Y'], false)
 *         ->select('in06', 'in06', 'in06', $arr, ['Y'])
 *         ->select('in07', 'in07', 'in07', $arr, ['N', 'Y'], true)
 *         ->button('in08', 'in08')
 *         ->button('in09', 'in09', ['class' => 'btn btn-primary'], 'reset')
 *         ->render();
 */

namespace Alessandrodesign\Formandtablecreator;
    
    
    use DOMDocument;
    use DOMElement;
    use DOMNode;

    /**
     * Class CreateForm
     * @package Source\Core
     */
    class CreateForm
    {
        /**
         * @var DOMDocument
         */
        private $dom;
        /**
         * @var array
         */
        private $attributes;
        
        //Structure
        /** @var DOMElement $form */
        private $form;
    
        /**
         * CreateForm constructor.
         * @param array $attributes
         * @param string|null $enctype
         */
        public function __construct(array $attributes, string $enctype = null)
        {
            $this->attributes = $attributes;
            $this->attributes['enctype'] = $enctype ?? 'multipart/form-data';
            $this->dom = new DOMDocument('1.0', 'UTF-8');
            $this->form = $this->dom->createElement('form');
        }
    
        /**
         * @param string $label
         * @param string $name
         * @param string $id
         * @param string|null $value
         * @param array|null $attributes
         * @param bool $inDiv
         * @param string|null $type
         * @param array $divAttributes
         * @param array|null $attrLabel
         * @return CreateForm
         */
        public function input(
            string $label,
            string $name,
            string $id,
            string $value = null,
            array $attributes = null,
            bool $inDiv = true,
            string $type = null,
            array $divAttributes = ['class' => 'form-group'],
            array $attrLabel = null
        ): CreateForm {
            $attributes['id'] = $id;
            $attributes['name'] = $name;
            $attributes['type'] = $type ?? 'text';
            if (!empty($value)) {
                $attributes['value'] = $value;
            }
            $this->inDiv(
                $inDiv,
                $divAttributes,
                $this->label($id, $label, $attrLabel),
                $this->tag('input', $attributes)
            );
            return $this;
        }
    
        /**
         * @param bool $inDiv
         * @param array $divAttributes
         * @param DOMNode $label
         * @param DOMNode $tag
         * @return DOMNode|null
         */
        private function inDiv(bool $inDiv, array $divAttributes, DOMNode $label, DOMNode $tag): ?DOMNode
        {
            $div = null;
            if ($inDiv) {
                $div = $this->tag('div', $divAttributes, null);
                $div->appendChild($label);
                $div->appendChild($tag);
                $this->form->appendChild($div);
            } else {
                $this->form->appendChild($label);
                $this->form->appendChild($tag);
            }
            return $div;
        }
    
        /**
         * @param string $name
         * @param array|null $attributes
         * @param string|null $value
         * @return DOMNode
         */
        private function tag(string $name, array $attributes = null, string $value = null): DOMNode
        {
            if (is_null($value)) {
                $tag = $this->dom->createElement($name);
            } else {
                $tag = $this->dom->createElement($name, $value);
            }
            
            if (!empty($attributes)) {
                foreach ($attributes as $attr => $val) {
                    $attribute = $this->dom->createAttribute($attr);
                    if (!is_null($val)) {
                        $attribute->value = $val;
                    }
                    $tag->appendChild($attribute);
                }
            }
            return $tag;
        }
    
        /**
         * @param string $id
         * @param string $label
         * @param array|null $attrLabel
         * @return DOMNode
         */
        public function label(string $id, string $label, array $attrLabel = null): DOMNode
        {
            $attrLabel['for'] = $id;
            return $this->tag('label', $attrLabel, $label);
        }
    
        /**
         * @param string $label
         * @param string $name
         * @param string $id
         * @param array $values
         * @param array|null $selected
         * @param bool $multiple
         * @param array|null $attributes
         * @param bool $inDiv
         * @param array $divAttributes
         * @param array|null $attrLabel
         * @return CreateForm
         */
        public function select(
            string $label,
            string $name,
            string $id,
            array $values,
            array $selected = null,
            bool $multiple = false,
            array $attributes = null,
            bool $inDiv = true,
            array $divAttributes = ['class' => 'form-group'],
            array $attrLabel = null
        ): CreateForm {
            $divs = null;
            
            if (!empty($values)) {
                foreach ($values as $key => $value) {
                    $attr['value'] = $value;
                    if (!empty($selected) && !is_null($selected) && in_array($value, $selected)) {
                        $attr['selected'] = null;
                    }
                    $divs[] = $this->tag('option', $attr, $key);
                    unset($attr['selected']);
                }
            }
            
            if ($multiple) {
                $attributes['multiple'] = null;
            }
            
            $attributes['id'] = $id;
            $attributes['name'] = $name;
            
            $select = $this->tag('select', $attributes);
            
            foreach ($divs as $tag) {
                $select->appendChild($tag);
            }
            
            $this->inDiv(
                $inDiv,
                $divAttributes,
                $this->label($id, $label, $attrLabel),
                $select
            );
            
            return $this;
        }
    
        /**
         * @param string $label
         * @param string $name
         * @param string $id
         * @param string|null $value
         * @param array|null $attributes
         * @param bool $inDiv
         * @param array $divAttributes
         * @param array|null $attrLabel
         * @return CreateForm
         */
        public function textarea(
            string $label,
            string $name,
            string $id,
            string $value = null,
            array $attributes = null,
            bool $inDiv = true,
            array $divAttributes = ['class' => 'form-group'],
            array $attrLabel = null
        ): CreateForm {
            $attributes['id'] = $id;
            $attributes['name'] = $name;
            $this->inDiv(
                $inDiv,
                $divAttributes,
                $this->label($id, $label, $attrLabel),
                $this->tag('textarea', $attributes, $value)
            );
            
            return $this;
        }
    
        /**
         * @param string $label
         * @param string $name
         * @param string $id
         * @param array $values
         * @param array|null $checked
         * @param bool $radio
         * @param array|null $attributes
         * @param bool $inDivAll
         * @param array $divAttributesAll
         * @param bool $inDiv
         * @param array $divAttributes
         * @param array $attrLabel
         * @return CreateForm
         */
        public function radio(
            string $label,
            string $name,
            string $id,
            array $values,
            array $checked = null,
            bool $radio = true,
            array $attributes = null,
            bool $inDivAll = true,
            array $divAttributesAll = ['class' => 'form-group'],
            bool $inDiv = true,
            array $divAttributes = ['class' => 'form-check'],
            array $attrLabel = ['class' => 'form-check-label']
        ): CreateForm {
            $divs = null;
            
            if (!empty($values)) {
                $i = 1;
                foreach ($values as $key => $value) {
                    $attributes['value'] = $value;
                    $attributes['name'] = $name;
                    $attributes['id'] = "{$id}_{$i}";
                    $attributes['type'] = $radio ? 'radio' : 'checkbox';
                    
                    if (!empty($checked) && !is_null($checked) && in_array($value, $checked)) {
                        $attributes['checked'] = null;
                    }
                    
                    $divs[] = $this->inDiv(
                        $inDiv,
                        $divAttributes,
                        $this->tag('input', $attributes),
                        $this->label($attributes['id'], $key, $attrLabel)
                    );
                    unset($attributes['checked']);
                    $i++;
                }
            }
            
            $localLabel = $this->label($id, $label);
            
            if ($inDivAll) {
                $div = $this->tag('div', $divAttributesAll, null);
                $div->appendChild($localLabel);
                foreach ($divs as $tag) {
                    $div->appendChild($tag);
                }
                $this->form->appendChild($div);
            }
            
            return $this;
        }
    
        /**
         * @param string $name
         * @param string $id
         * @param array $attributes
         * @param string $type
         * @param bool $inDiv
         * @param array $divAttributes
         * @return CreateForm
         */
        public function button(
            string $name,
            string $id,
            array $attributes = ['class' => 'btn btn-primary'],
            string $type = 'submit',
            bool $inDiv = true,
            array $divAttributes = ['class' => 'form-group']
        ): CreateForm {
            
            $attributes['id'] = $id;
            $attributes['type'] = $type;
            
            $this->inDiv(
                $inDiv,
                $divAttributes,
                $this->label($id, '&nbsp;'),
                $this->tag('button', $attributes, $name));
            
            return $this;
        }
    
        /**
         * @return string
         */
        public function render(): string
        {
            foreach ($this->attributes as $attr => $value) {
                $attribute = $this->dom->createAttribute($attr);
                $attribute->value = $value;
                $this->form->appendChild($attribute);
            }
            $this->dom->appendChild($this->form);
            return $this->dom->saveHTML();
        }
    }