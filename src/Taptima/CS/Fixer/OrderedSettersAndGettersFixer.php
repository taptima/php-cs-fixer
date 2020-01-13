<?php

declare(strict_types=1);

namespace Taptima\CS\Fixer;

use Doctrine\Common\Inflector\Inflector;
use PhpCsFixer\Fixer\ClassNotation\OrderedClassElementsFixer;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use Taptima\CS\Priority;

final class OrderedSettersAndGettersFixer extends AbstractOrderedClassElementsFixer
{
    /**
     * {@inheritdoc}
     */
    public function isCandidate(Tokens $tokens)
    {
        return $tokens->isAnyTokenKindsFound(Token::getClassyTokenKinds());
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return Priority::before(OrderedClassElementsFixer::class);
    }

    /**
     * {@inheritdoc}
     */
    public function getDocumentation()
    {
        return 'Class/interface/trait setters and getters MUST BE ordered (order is setter, isser, hasser, adder, remover, getter).';
    }

    /**
     * {@inheritdoc}
     */
    public function getSampleCode()
    {
        return <<<'PHP'
<?php

namespace App\Model;

class User
{
    /**
     * @var string
     */
    private $identifier;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $enabled;

    /**
     * @var Item
     */
    private $items;

    public function __construct(array $data)
    {
        $this->items = new ArrayCollection();
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function isEnabled()
    {
        return $this->enabled;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function enable()
    {
        $this->enabled = true;
    }

    public function disable()
    {
        $this->enabled = false;
    }

    /**
     * @param Item $items
     *
     * @return User
     */
    public function setItems(Item $items)
    {
        $this->items = $items;
        return $this;
    }

    /**
     * @return Item
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param Item $item
     * @return User
     */
    public function addItem(Item $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * @param Item $item
     * @return User
     */
    public function removeItem(Item $item)
    {
        $this->items->removeElement($item);

        return $this;
    }
}
PHP;
    }

    /**
     * {@inheritdoc}
     */
    protected function sortElements(array $elements)
    {
        $methods  = $this->getMethodsNames($elements);
        $portions = [];

        foreach ($methods as $i => $method) {
            foreach ($elements as $index => $element) {
                if ($element['type'] !== 'method') {
                    continue;
                }

                if ($element['methodName'] === $method['name']) {
                    $portions[$method['name']] = [
                        'element' => $element,
                        'before'  => $method['before'],
                        'after'   => $method['after'],
                    ];
                }
            }
        }

        $result             = [];
        $usedMethodElements = [];

        $addToResult = static function ($element, $isMethod = true) use (&$result, &$usedMethodElements) {
            $result[] = $element;

            if ($isMethod) {
                $usedMethodElements[$element['methodName']] = true;
            }
        };

        foreach ($elements as $element) {
            if ($element['type'] !== 'method') {
                $addToResult($element, false);

                continue;
            }

            if (array_key_exists($element['methodName'], $usedMethodElements)) {
                continue;
            }

            if (!array_key_exists($element['methodName'], $portions)) {
                $addToResult($element);

                continue;
            }

            foreach ($portions[$element['methodName']]['before'] as $method) {
                if (!array_key_exists($method, $portions) || array_key_exists($method, $usedMethodElements)) {
                    continue;
                }

                $addToResult($portions[$method]['element']);
            }

            $addToResult($element);

            foreach ($portions[$element['methodName']]['after'] as $method) {
                if (!array_key_exists($method, $portions) || array_key_exists($method, $usedMethodElements)) {
                    continue;
                }

                $addToResult($portions[$method]['element']);
            }
        }

        return $result;
    }

    /**
     * @param array $elements
     *
     * @return array
     */
    private function getMethodsNames(array $elements)
    {
        $result = [];

        foreach ($this->getPropertiesNames($elements) as $name) {
            $methods = [sprintf('set%s', ucfirst($name))];

            foreach ((array) Inflector::singularize($name) as $singular) {
                $methods[] = sprintf('add%s', ucfirst($singular));
                $methods[] = sprintf('remove%s', ucfirst($singular));
            }

            $methods[] = sprintf('is%s', ucfirst($name));
            $methods[] = sprintf('has%s', ucfirst($name));
            $methods[] = sprintf('get%s', ucfirst($name));

            for ($i = 0, $max = count($methods); $i < $max; ++$i) {
                $result[] = $this->createMethodDescription($methods[$i], array_slice($methods, 0, $i), array_slice($methods, $i + 1, $max));
            }
        }

        return $result;
    }

    /**
     * @param string $name
     * @param array  $beforeMethods
     * @param array  $afterMethods
     *
     * @return array
     */
    private function createMethodDescription($name, array $beforeMethods = [], array $afterMethods = [])
    {
        return [
            'name'   => $name,
            'before' => $beforeMethods,
            'after'  => $afterMethods,
        ];
    }

    /**
     * @param array $elements
     *
     * @return array
     */
    private function getPropertiesNames(array $elements)
    {
        $properties = array_filter($elements, function ($element) {
            return $element['type'] === 'property';
        });

        return array_map(function ($element) {
            return ltrim($element['propertyName'], '$');
        }, $properties);
    }
}
