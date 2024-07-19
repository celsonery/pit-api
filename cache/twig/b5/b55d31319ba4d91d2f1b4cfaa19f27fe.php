<?php

use Twig\Environment;
use Twig\Error\RuntimeError;
use Twig\Source;
use Twig\Template;

/* doctum-search.json.twig */
class __TwigTemplate_a1a0e67f2f2599d2950dbfb308bbac26 extends Template
{
    private $source;

    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo isset($context['search_index']) || array_key_exists('search_index', $context) ? $context['search_index'] : (function () {
            throw new RuntimeError('Variable "search_index" does not exist.', 1, $this->source);
        })();
        echo '
';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return 'doctum-search.json.twig';
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable()
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo()
    {
        return [37 => 1];
    }

    public function getSourceContext()
    {
        return new Source('{{ search_index|raw }}
', 'doctum-search.json.twig', 'phar:///home/celso/Devel/projects/oregon/pit/api/doctum.phar/src/Resources/themes/default/doctum-search.json.twig');
    }
}
