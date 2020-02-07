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

/* core/themes/classy/templates/navigation/pager.html.twig */
class __TwigTemplate_3d4102a335206a270d09cd388579f823033a581e1c29f34a3a1715d0a0071a36 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $tags = ["if" => 33, "for" => 60, "set" => 63];
        $filters = ["escape" => 34, "t" => 35, "without" => 40, "default" => 42];
        $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['if', 'for', 'set'],
                ['escape', 't', 'without', 'default'],
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
        // line 33
        if (($context["items"] ?? null)) {
            // line 34
            echo "  <nav class=\"pager\" role=\"navigation\" aria-labelledby=\"";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["heading_id"] ?? null)), "html", null, true);
            echo "\">
    <h4 id=\"";
            // line 35
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["heading_id"] ?? null)), "html", null, true);
            echo "\" class=\"visually-hidden\">";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar(t("Pagination"));
            echo "</h4>
    <ul class=\"pager__items js-pager__items\">";
            // line 38
            if ($this->getAttribute(($context["items"] ?? null), "first", [])) {
                // line 39
                echo "        <li class=\"pager__item pager__item--first\">
          <a href=\"";
                // line 40
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute(($context["items"] ?? null), "first", []), "href", [])), "html", null, true);
                echo "\" title=\"";
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar(t("Go to first page"));
                echo "\"";
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->env->getExtension('Drupal\Core\Template\TwigExtension')->withoutFilter($this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute(($context["items"] ?? null), "first", []), "attributes", [])), "href", "title"), "html", null, true);
                echo ">
            <span class=\"visually-hidden\">";
                // line 41
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar(t("First page"));
                echo "</span>
            <span aria-hidden=\"true\">";
                // line 42
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, (($this->getAttribute($this->getAttribute(($context["items"] ?? null), "first", [], "any", false, true), "text", [], "any", true, true)) ? (_twig_default_filter($this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute(($context["items"] ?? null), "first", [], "any", false, true), "text", [])), t("« First"))) : (t("« First"))), "html", null, true);
                echo "</span>
          </a>
        </li>";
            }
            // line 47
            if ($this->getAttribute(($context["items"] ?? null), "previous", [])) {
                // line 48
                echo "        <li class=\"pager__item pager__item--previous\">
          <a href=\"";
                // line 49
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute(($context["items"] ?? null), "previous", []), "href", [])), "html", null, true);
                echo "\" title=\"";
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar(t("Go to previous page"));
                echo "\" rel=\"prev\"";
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->env->getExtension('Drupal\Core\Template\TwigExtension')->withoutFilter($this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute(($context["items"] ?? null), "previous", []), "attributes", [])), "href", "title", "rel"), "html", null, true);
                echo ">
            <span class=\"visually-hidden\">";
                // line 50
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar(t("Previous page"));
                echo "</span>
            <span aria-hidden=\"true\">";
                // line 51
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, (($this->getAttribute($this->getAttribute(($context["items"] ?? null), "previous", [], "any", false, true), "text", [], "any", true, true)) ? (_twig_default_filter($this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute(($context["items"] ?? null), "previous", [], "any", false, true), "text", [])), t("‹ Previous"))) : (t("‹ Previous"))), "html", null, true);
                echo "</span>
          </a>
        </li>";
            }
            // line 56
            if ($this->getAttribute(($context["ellipses"] ?? null), "previous", [])) {
                // line 57
                echo "        <li class=\"pager__item pager__item--ellipsis\" role=\"presentation\">&hellip;</li>";
            }
            // line 60
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["items"] ?? null), "pages", []));
            foreach ($context['_seq'] as $context["key"] => $context["item"]) {
                // line 61
                echo "        <li class=\"pager__item";
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar((((($context["current"] ?? null) == $context["key"])) ? (" is-active") : ("")));
                echo "\">";
                // line 62
                if ((($context["current"] ?? null) == $context["key"])) {
                    // line 63
                    $context["title"] = t("Current page");
                } else {
                    // line 65
                    $context["title"] = t("Go to page @key", ["@key" => $context["key"]]);
                }
                // line 67
                echo "          <a href=\"";
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($context["item"], "href", [])), "html", null, true);
                echo "\" title=\"";
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["title"] ?? null)), "html", null, true);
                echo "\"";
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->env->getExtension('Drupal\Core\Template\TwigExtension')->withoutFilter($this->sandbox->ensureToStringAllowed($this->getAttribute($context["item"], "attributes", [])), "href", "title"), "html", null, true);
                echo ">
            <span class=\"visually-hidden\">";
                // line 69
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar((((($context["current"] ?? null) == $context["key"])) ? (t("Current page")) : (t("Page"))));
                echo "
            </span>";
                // line 71
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($context["key"]), "html", null, true);
                // line 72
                echo "</a>
        </li>";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['key'], $context['item'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 76
            if ($this->getAttribute(($context["ellipses"] ?? null), "next", [])) {
                // line 77
                echo "        <li class=\"pager__item pager__item--ellipsis\" role=\"presentation\">&hellip;</li>";
            }
            // line 80
            if ($this->getAttribute(($context["items"] ?? null), "next", [])) {
                // line 81
                echo "        <li class=\"pager__item pager__item--next\">
          <a href=\"";
                // line 82
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute(($context["items"] ?? null), "next", []), "href", [])), "html", null, true);
                echo "\" title=\"";
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar(t("Go to next page"));
                echo "\" rel=\"next\"";
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->env->getExtension('Drupal\Core\Template\TwigExtension')->withoutFilter($this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute(($context["items"] ?? null), "next", []), "attributes", [])), "href", "title", "rel"), "html", null, true);
                echo ">
            <span class=\"visually-hidden\">";
                // line 83
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar(t("Next page"));
                echo "</span>
            <span aria-hidden=\"true\">";
                // line 84
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, (($this->getAttribute($this->getAttribute(($context["items"] ?? null), "next", [], "any", false, true), "text", [], "any", true, true)) ? (_twig_default_filter($this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute(($context["items"] ?? null), "next", [], "any", false, true), "text", [])), t("Next ›"))) : (t("Next ›"))), "html", null, true);
                echo "</span>
          </a>
        </li>";
            }
            // line 89
            if ($this->getAttribute(($context["items"] ?? null), "last", [])) {
                // line 90
                echo "        <li class=\"pager__item pager__item--last\">
          <a href=\"";
                // line 91
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute(($context["items"] ?? null), "last", []), "href", [])), "html", null, true);
                echo "\" title=\"";
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar(t("Go to last page"));
                echo "\"";
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->env->getExtension('Drupal\Core\Template\TwigExtension')->withoutFilter($this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute(($context["items"] ?? null), "last", []), "attributes", [])), "href", "title"), "html", null, true);
                echo ">
            <span class=\"visually-hidden\">";
                // line 92
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar(t("Last page"));
                echo "</span>
            <span aria-hidden=\"true\">";
                // line 93
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, (($this->getAttribute($this->getAttribute(($context["items"] ?? null), "last", [], "any", false, true), "text", [], "any", true, true)) ? (_twig_default_filter($this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute(($context["items"] ?? null), "last", [], "any", false, true), "text", [])), t("Last »"))) : (t("Last »"))), "html", null, true);
                echo "</span>
          </a>
        </li>";
            }
            // line 97
            echo "    </ul>
  </nav>";
        }
    }

    public function getTemplateName()
    {
        return "core/themes/classy/templates/navigation/pager.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  208 => 97,  202 => 93,  198 => 92,  190 => 91,  187 => 90,  185 => 89,  179 => 84,  175 => 83,  167 => 82,  164 => 81,  162 => 80,  159 => 77,  157 => 76,  150 => 72,  148 => 71,  144 => 69,  135 => 67,  132 => 65,  129 => 63,  127 => 62,  123 => 61,  119 => 60,  116 => 57,  114 => 56,  108 => 51,  104 => 50,  96 => 49,  93 => 48,  91 => 47,  85 => 42,  81 => 41,  73 => 40,  70 => 39,  68 => 38,  62 => 35,  57 => 34,  55 => 33,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "core/themes/classy/templates/navigation/pager.html.twig", "C:\\xampp\\htdocs\\vork\\core\\themes\\classy\\templates\\navigation\\pager.html.twig");
    }
}
