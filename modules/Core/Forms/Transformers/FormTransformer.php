<?php namespace Modules\Core\Forms\Transformers;

use League\Fractal\TransformerAbstract;
use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Fields\FormField;

class FormTransformer extends TransformerAbstract {

    /**
     * This transformer will use reflection to access
     * otherwise inaccessible methods that need to be
     * called on the form to convert to json. This is not
     * ideal but the only other alternative would be to fork
     * and modify the library. I think this is the lesser of two evils.
     *
     * @param Form $form
     *   The form.
     *
     * @return array
     */
    public function transform(Form $form) {

        $cls = get_class($form);
        $reflectionMethod = new \ReflectionMethod($cls, 'setupNamedModel');
        $reflectionMethod->setAccessible(true);

        $data = [];
        $reflectionMethod->invoke($form);

        $data['formOptions'] = $form->getFormOptions();

        // @todo: This will need to be implemented as a transformer when/if used.
        $data['model'] = $form->getModel();

        // Separate transformer will be used for each field for maximum flexibility.
        $fields = $form->getFields();
        foreach($fields as $field) {
            $name = $field->getName();
            $data['fields'][$name] = $this->transformField($field);
        }

        return $data;

    }

    /**
     * Transform an individual field. Explore how to make this into a separate
     * transformer transformer.
     *
     * @param FormField $formField
     *   The form field.
     *
     * @return array
     */
    public function transformField(FormField $formField) {

        $cls = get_class($formField);
        $reflectionClass = new \ReflectionClass($cls);

        $reflectionMethod = new \ReflectionMethod($cls, 'prepareOptions');
        $reflectionMethod->setAccessible(true);

        $reflectionMethod->invoke($formField,[]);

        $value = $formField->getValue();
        $defaultValue = $formField->getDefaultValue();

        $reflectionMethod = new \ReflectionMethod($cls, 'isValidValue');
        $reflectionMethod->setAccessible(true);

        $reflectionProperty = $reflectionClass->getProperty('valueProperty');
        $reflectionProperty->setAccessible(true);
        $valueProperty = $reflectionProperty->getValue($formField);

        // Override default value with value
        if (
            !$reflectionMethod->invoke($formField,$value) &&
            $reflectionMethod->invoke($formField,$defaultValue)
        ) {
            $this->setOption($valueProperty, $defaultValue);
        }

        $reflectionMethod = new \ReflectionMethod($cls, 'getRenderData');
        $reflectionMethod->setAccessible(true);

        $data = $reflectionMethod->invoke($formField);
        $data = $data + [
                'name' => $formField->getName(),
                'nameKey' => $formField->getNameKey(),
                'type' => $formField->getType(),
                'options' => $formField->getOptions(),
                // @todo: Figure out what to do with these.
                //'showLabel' => $showLabel,
                //'showField' => $showField,
                //'showError' => $showError
            ];

        return $data;

    }

}