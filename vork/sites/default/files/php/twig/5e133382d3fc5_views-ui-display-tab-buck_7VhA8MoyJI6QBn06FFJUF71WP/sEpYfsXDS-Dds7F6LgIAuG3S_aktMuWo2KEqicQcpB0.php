<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* core/themes/stable/templates/admin/views-ui-display-tab-bucket.html.twig */
class __TwigTemplate_f6ee1ee038c2befe60d99fea847e3f8fab7b74f1820de78cc46a7c48571d7bf5 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $tags = ["set" => 19, "if" => 26];
        $filters = ["clean_class" => 21, "escape" => 25];
        $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['set', 'if'],
                ['clean_class', 'escape'],
                []
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->getSourceContext());

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 19
        $context["classes"] = [0 => "views-ui-display-tab-bucket", 1 => ((        // line 21
($context["name"] ?? null)) ? (\Drupal\Component\Utility\Html::getClass($this->sandbox->ensureToStringAllowed(($context["name"] ?? null)))) : ("")), 2 => ((        // line 22
($context["overridden"] ?? null)) ? ("overridden") : (""))];
        // line 25
        echo "<div";
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["attributes"] ?? null), "addClass", [0 => ($context["classes"] ?? null)], "method")), "html", null, true);
        echo ">";
        // line 26
        if (($context["title"] ?? null)) {
            // line 27
            echo "<h3 class=\"views-ui-display-tab-bucket__title\">";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["title"] ?? null)), "html", null, true);
            echo "</h3>";
        }
        // line 29
        if (($context["actions"] ?? null)) {
            // line 30
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["actions"] ?? null)), "html", null, true);
        }
        // line 32
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["content"] ?? null)), "html", null, true);
        echo "
</div>
";
    }

    public function getTemplateName()
    {
        return "core/themes/stable/templates/admin/views-ui-display-tab-bucket.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  75 => 32,  72 => 30,  70 => 29,  65 => 27,  63 => 26,  59 => 25,  57 => 22,  56 => 21,  55 => 19,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "core/themes/stable/templates/admin/views-ui-display-tab-bucket.html.twig", "C:\\xampp\\htdocs\\vork\\core\\themes\\stable\\templates\\admin\\views-ui-display-tab-bucket.html.twig");
    }
}
