<?php

/* select_lang.twig */
class __TwigTemplate_18a843babdaa63257d81ead8bf3295a9402a81b01bb5627a827d04eac1dbca32 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        echo "    <form method=\"get\" action=\"index.php\" class=\"disableAjax\">
    ";
        // line 2
        echo PhpMyAdmin\Url::getHiddenInputs((isset($context["_form_params"]) ? $context["_form_params"] : null));
        echo "

    ";
        // line 4
        if ((isset($context["use_fieldset"]) ? $context["use_fieldset"] : null)) {
            // line 5
            echo "        <fieldset>
            <legend lang=\"en\" dir=\"ltr\">";
            // line 6
            echo (isset($context["language_title"]) ? $context["language_title"] : null);
            echo "</legend>
    ";
        } else {
            // line 8
            echo "        <bdo lang=\"en\" dir=\"ltr\">
            <label for=\"sel-lang\">";
            // line 9
            echo (isset($context["language_title"]) ? $context["language_title"] : null);
            echo "</label>
        </bdo>
    ";
        }
        // line 12
        echo "
    <select name=\"lang\" class=\"autosubmit\" lang=\"en\" dir=\"ltr\" id=\"sel-lang\">

    ";
        // line 15
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["available_languages"]) ? $context["available_languages"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["language"]) {
            // line 16
            echo "        ";
            // line 17
            echo "        <option value=\"";
            echo twig_escape_filter($this->env, twig_lower_filter($this->env, $this->getAttribute($context["language"], "getCode", [], "method")), "html", null, true);
            echo "\"";
            // line 18
            if ($this->getAttribute($context["language"], "isActive", [], "method")) {
                // line 19
                echo "                selected=\"selected\"";
            }
            // line 21
            echo ">
        ";
            // line 22
            echo $this->getAttribute($context["language"], "getName", [], "method");
            echo "
        </option>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['language'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 25
        echo "
    </select>

    ";
        // line 28
        if ((isset($context["use_fieldset"]) ? $context["use_fieldset"] : null)) {
            // line 29
            echo "        </fieldset>
    ";
        }
        // line 31
        echo "
    </form>
";
    }

    public function getTemplateName()
    {
        return "select_lang.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  89 => 31,  85 => 29,  83 => 28,  78 => 25,  69 => 22,  66 => 21,  63 => 19,  61 => 18,  57 => 17,  55 => 16,  51 => 15,  46 => 12,  40 => 9,  37 => 8,  32 => 6,  29 => 5,  27 => 4,  22 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "select_lang.twig", "C:\\xampp_old\\phpMyAdmin\\templates\\select_lang.twig");
    }
}
