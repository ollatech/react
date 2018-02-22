<?php

namespace Olla\React\Twig;

use Olla\React\Render;
use Olla\React\Context;


class ReactExtension extends \Twig_Extension
{
    private $render;
    private $context;
    private $server_side;
    private $domid;
    private $store;

    public function __construct(Render $render = null, Context $context, string $server_side = false, string $store = null)
    {
        $this->render = $render;
        $this->context = $context;
        $this->server_side = $server_side;
        $this->domid = json_encode('react'.uniqid('reactRenderer', true));
        $this->store = $store;
    }

    
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('react_render', array($this, 'render'), array('is_safe' => array('html')))
        );
    }

    public function render($componentName, array $props = [], array $contexts = [], array $options = []) {
        $componentName = json_encode($componentName);
        $props = json_encode($props);
        $contexts = $this->context->get();
        $str = '';
        $str .= '<div id="'.$this->domid.'">';
        if($this->server_side) {
            $render = $this->server($componentName, $props, $contexts, $options);
            if ($render['hasErrors']) {
                $str .= $render['errors'];
            } else {
                $str .= $render['html'];
            }
        }
        $str .= '</div>';
        $str .= $this->broswer($componentName, $props, $contexts, $options);
        return $str;
    }


    public function server($component, array $props = [], array $contexts = [], array $options = []) {
        $component = $this->component($componentName, $props, $contexts, $options, true);
        return $this->render->execute($component);
    }

    public function broswer($component, array $props = [], array $contexts = [], array $options = []) {
        $component = $this->component($componentName, $props, $contexts, $options);
        return  sprintf('<script>%s</script>', $component);
    }

    public function component($componentName, array $props = [], array $contexts = [], bool $server = false) {
        $code = <<<JS
        (function() { return ReactOnApp.render(%s, %s, %s, %s, %s, %s) })();
JS;
        return  sprintf($code, $this->domid, $componentName, $props, $contexts, $server);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'olla_react_extension';
    }
}
