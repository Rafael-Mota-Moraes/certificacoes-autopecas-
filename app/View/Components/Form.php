<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Form extends Component
{
    public string $action;
    public string $method;
    public ?string $spoofMethod = null;

    /**
     * Create a new component instance.
     *
     * @param string $action A URL para onde o formulário será enviado.
     * @param string $method O método HTTP (GET, POST, PUT, PATCH, DELETE).
     * @return void
     */
    public function __construct(string $action, string $method = 'POST')
    {
        $this->action = $action;
        $this->method = strtoupper($method);

        if (!in_array($this->method, ['GET', 'POST'])) {
            $this->spoofMethod = $this->method;
            $this->method = 'POST';
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form');
    }
}
