<?php

declare(strict_types=1);

namespace tests\UseCase\OrderedSettersAndGetters;

use Taptima\CS\Fixer\OrderedSettersAndGettersFixer;
use tests\UseCase;

final class OrderedSettersAndGettersFirst implements UseCase
{
    /**
     * {@inheritdoc}
     */
    public function getFixer()
    {
        return new OrderedSettersAndGettersFixer();
    }

    /**
     * {@inheritdoc}
     */
    public function getRawScript()
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
     * @var ArrayCollection
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

    public function setItems($items)
    {
        $this->items = $items;
    }

    public function enable()
    {
        $this->enabled = true;
    }

    public function disable()
    {
        $this->enabled = false;
    }

    public function removeItem($item)
    {
        $this->items->removeElement($item);

        return $this;
    }

    public function isEnabled()
    {
        return $this->enabled;
    }

    public function getName()
    {
        return $this->name;
    }

    public function addItem($item)
    {
        $this->items[] = $item;

        return $this;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function hasIdentifier()
    {
        return null !== $this->identifier;
    }

    public function getItems($items)
    {
        return $this->items;
    }
}
PHP;
    }

    /**
     * {@inheritdoc}
     */
    public function getExpectation()
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
     * @var ArrayCollection
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

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setItems($items)
    {
        $this->items = $items;
    }

    public function addItem($item)
    {
        $this->items[] = $item;

        return $this;
    }

    public function removeItem($item)
    {
        $this->items->removeElement($item);

        return $this;
    }

    public function getItems($items)
    {
        return $this->items;
    }

    public function enable()
    {
        $this->enabled = true;
    }

    public function disable()
    {
        $this->enabled = false;
    }

    public function isEnabled()
    {
        return $this->enabled;
    }

    public function hasIdentifier()
    {
        return null !== $this->identifier;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }
}
PHP;
    }

    /**
     * {@inheritdoc}
     */
    public function getMinSupportedPhpVersion()
    {
        return 0;
    }
}
