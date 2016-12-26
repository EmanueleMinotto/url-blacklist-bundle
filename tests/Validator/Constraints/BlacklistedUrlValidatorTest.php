<?php

namespace EmanueleMinotto\UrlBlacklistBundle\Validator\Constraints;

use Doctrine\Common\Persistence\ObjectManager;
use EmanueleMinotto\UrlBlacklistBundle\Entity\Url;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class BlacklistedUrlValidatorTest extends TestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->objectManager = $this->createMock(ObjectManager::class);
        $this->executionContext = $this->createMock(ExecutionContextInterface::class);

        $this->validator = new BlacklistedUrlValidator($this->objectManager);
        $this->validator->initialize($this->executionContext);
    }

    public function testSimpleValidate()
    {
        $constraint = new BlacklistedUrl();

        $this->executionContext
            ->expects($this->never())
            ->method('addViolation');

        $this->validator->validate(null, $constraint);
        $this->validator->validate('', $constraint);
        $this->validator->validate(' ', $constraint);
    }

    public function testValidateWithObjectManagerMissed()
    {
        $url = 'http://www.example.com/';
        $constraint = new BlacklistedUrl();

        $this->executionContext
            ->expects($this->never())
            ->method('addViolation');

        $this->objectManager
            ->expects($this->once())
            ->method('find')
            ->with(Url::class, $url);

        $this->validator->validate($url, $constraint);
    }

    /**
     * @param string $category
     * @param string $value
     *
     * @dataProvider objectManagerDataProvider
     */
    public function testValidateWithObjectManagerHit($category, $value)
    {
        $constraint = new BlacklistedUrl();

        $this->executionContext
            ->expects($this->once())
            ->method('addViolation')
            ->with($constraint->message, [
                '%category%' => $category,
                '%location%' => $value,
                '%value%' => $value,
            ]);

        $entity = new Url();
        $entity->setLocation($value);
        $entity->setCategory($category);

        $this->objectManager
            ->expects($this->once())
            ->method('find')
            ->with(Url::class, $value)
            ->willReturn($entity);

        $this->validator->validate($value, $constraint);
    }

    public static function objectManagerDataProvider()
    {
        yield ['http://www.example.com/', 'test1'];
        yield ['http://www.example.com/', 'test2'];
        yield ['http://www.example.net/', 'test3'];
    }
}
