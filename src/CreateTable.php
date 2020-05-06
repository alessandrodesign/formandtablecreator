<?php
    /**
     * Copyright (c) 2020. AlessandroDESIGN - Tecnologias.
     * Como Usar:
     *
     * $table = new CreateTable(
     *         [
     *             'id' => 'table',
     *             'class' => 'table table-hover'
     *         ],
     *         'div',
     *         ['class' => 'table-responsive']
     *     );
     *
     *     echo $table
     *         ->header(['ID', 'NOME', 'AÇÃO'])
     *         ->body([
     *             [1, 'ALEX'],
     *             [2, 'BIIA']
     *         ], [
     *             [
     *                 'tag' => 'a',
     *                 'value' => ['tag' => 'i', 'value' => 'editar', 'attr' => ['class' => 'fas fa-edit']],
     *                 'attr' => ['class' => 'btn btn-success', 'href' => 'editar']
     *             ],
     *             [
     *                 'tag' => 'a',
     *                 'value' => ['tag' => 'i', 'value' => 'delete', 'attr' => ['class' => 'fas fa-times']],
     *                 'attr' => ['class' => 'btn btn-danger delete', 'href' => 'delete']
     *             ]
     *         ])
     *         ->footer(['ID', 'NOME', 'AÇÃO'])
     *         ->render();
     */
    
    namespace Alessandrodesign\Formandtablecreator;
    
    use DOMDocument;
    use DOMElement;
    use DOMNode;
    
    /**
     * Class CreateTable
     * @package Source\Core
     */
    class CreateTable
    {
        
        /**
         * @var DOMDocument
         */
        private $dom;
        /**
         * @var array
         */
        private $attributes;
        /**
         * @var string
         */
        private $divFather;
        /**
         * @var array
         */
        private $attrDivFather;
        
        //Structure
        /** @var DOMElement $table */
        private $table;
        
        /**
         * CreateTable constructor.
         * @param array $attributes
         * @param string|null $divFather
         * @param array $attrDivFather
         */
        public function __construct(array $attributes, string $divFather = null, array $attrDivFather = [])
        {
            $this->attrDivFather = $attrDivFather;
            $this->attributes = $attributes;
            $this->divFather = $divFather;
            $this->dom = new DOMDocument('1.0', 'UTF-8');
            $this->table = $this->dom->createElement('table');
        }
        
        /**
         * @param array $columns
         * @return CreateTable
         */
        public function header(array $columns): CreateTable
        {
            $thead = $this->dom->createElement('thead');
            $tr = $this->dom->createElement('tr');
            foreach ($columns as $value) {
                $th = $this->dom->createElement('th', $value);
                $tr->appendChild($th);
                $thead->appendChild($tr);
            }
            $this->table->appendChild($thead);
            
            return $this;
        }
        
        /**
         * @param array $columns
         * @param array|null $buttons
         * @return CreateTable
         */
        public function body(array $columns, array $buttons = null): CreateTable
        {
            $tbody = $this->dom->createElement('tbody');
            foreach ($columns as $item) {
                $tr = $this->dom->createElement('tr');
                foreach ($item as $key => $value) {
                    if (is_numeric($key)) {
                        $td = $this->dom->createElement('td', $value);
                        $tr->appendChild($td);
                    } else {
                        if (!is_null($buttons)) {
                            $td = $this->dom->createElement('td');
                            foreach ($buttons as $button) {
                                $btn = $this->createButton($button, $key, $value);
                                $td->appendChild($btn);
                                $tr->appendChild($td);
                            }
                        }
                    }
                }
                $tbody->appendChild($tr);
            }
            $this->table->appendChild($tbody);
            
            return $this;
        }
        
        /**
         * @param array $button
         * @param string|null $find
         * @param string|null $item
         * @return DOMNode
         */
        private function createButton(array $button, string $find = null, string $item = null): DOMNode
        {
            $btn = (object)$button;
            if (isset($btn->value) && is_array($btn->value)) {
                $tag = $this->dom->createElement($btn->tag);
                $child = $this->createButton($btn->value);
                $tag->appendChild($child);
            } else {
                $tag = $this->dom->createElement($btn->tag, str_replace($find, $item, $btn->value) ?? null);
            }
            
            foreach ($btn->attr as $attr => $value) {
                $attribute = $this->dom->createAttribute($attr);
                $attribute->value = $value;
                $tag->appendChild($attribute);
            }
            return $tag;
        }
        
        /**
         * @param array $columns
         * @return CreateTable
         */
        public function footer(array $columns): CreateTable
        {
            $tfoot = $this->dom->createElement('tfoot');
            $tr = $this->dom->createElement('tr');
            foreach ($columns as $value) {
                $th = $this->dom->createElement('th', $value);
                $tr->appendChild($th);
                $tfoot->appendChild($tr);
            }
            $this->table->appendChild($tfoot);
            
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
                $this->table->appendChild($attribute);
            }
            if (!is_null($this->divFather)) {
                $div = $this->dom->createElement($this->divFather);
                
                if (!empty($this->attrDivFather)) {
                    foreach ($this->attrDivFather as $attr => $value) {
                        $attribute = $this->dom->createAttribute($attr);
                        $attribute->value = $value;
                        $div->appendChild($attribute);
                    }
                }
                $div->appendChild($this->table);
                $this->dom->appendChild($div);
            } else {
                $this->dom->appendChild($this->table);
            }
            return $this->dom->saveHTML();
        }
    }