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

/* core/themes/stable/templates/admin/views-ui-views-listing-table.html.twig */
class __TwigTemplate_819ed9b518b0908298828bef4b1ef2c10619417c23bbd9373316350e697f68f2 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $tags = ["for" => 21];
        $filters = ["escape" => 18];
        $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['for'],
                ['escape'],
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
        // line 18
        echo "<table";
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["attributes"] ?? null), "addClass", [0 => "responsive-enabled"], "method")), "html", null, true);
        echo ">
  <thead>
    <tr>";
        // line 21
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["headers"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["header"]) {
            // line 22
            echo "        <th";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($context["header"], "attributes", [])), "html", null, true);
            echo ">";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($context["header"], "data", [])), "html", null, true);
            echo "</th>";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['header'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 24
        echo "    </tr>
  </thead>
  <tbody>";
        // line 27
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["rows"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
            // line 28
            echo "      <tr";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($context["row"], "attributes", [])), "html", null, true);
            echo ">
        <td class=\"views-ui-view-name\">
          <h3 data-drupal-selector=\"views-table-filter-text-source\">";
            // line 30
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute($this->getAttribute($context["row"], "data", []), "view_name", []), "data", [])), "html", null, true);
            echo "</h3>
        </td>
        <td class=\"views-ui-view-machine-name\" data-drupal-selector=\"views-table-filter-text-source\">";
            // line 33
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute($this->getAttribute($context["row"], "data", []), "machine_name", []), "data", [])), "html", null, true);
            echo "
        </td>
        <td class=\"views-ui-view-description\" data-drupal-selector=\"views-table-filter-text-source\">";
            // line 36
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute($this->getAttribute($context["row"], "data", []), "description", []), "data", [])), "html", null, true);
            echo "
        </td>
        <td class=\"views-ui-view-displays\">";
            // line 39
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute($this->getAttribute($context["row"], "data", []), "displays", []), "data", [])), "html", null, true);
            echo "
        </td>
        <td class=\"views-ui-view-operations\">";
            // line 42
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute($this->getAttribute($context["row"], "data", []), "operations", []), "data", [])), "html", null, true);
            echo "
        </td>
      </tr>";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 46
        echo "  </tbody>
</table>
";
    }

    public function getTemplateName()
    {
        return "core/themes/stable/templates/admin/views-ui-views-listing-table.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  118 => 46,  109 => 42,  104 => 39,  99 => 36,  94 => 33,  89 => 30,  83 => 28,  79 => 27,  75 => 24,  65 => 22,  61 => 21,  55 => 18,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "core/themes/stable/templates/admin/views-ui-views-listing-table.html.twig", "C:\\xampp\\htdocs\\vork\\core\\themes\\stable\\templates\\admin\\views-ui-views-listing-table.html.twig");
    }
}
