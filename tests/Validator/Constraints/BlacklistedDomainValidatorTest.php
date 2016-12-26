<?php

namespace EmanueleMinotto\UrlBlacklistBundle\Validator\Constraints;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use EmanueleMinotto\UrlBlacklistBundle\Entity\Domain;
use InvalidArgumentException;
use Pdp\Parser;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class BlacklistedDomainValidatorTest extends TestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->objectManager = $this->createMock(ObjectManager::class);
        $this->parser = $this->createMock(Parser::class);
        $this->executionContext = $this->createMock(ExecutionContextInterface::class);

        $this->validator = new BlacklistedDomainValidator($this->objectManager, $this->parser);
        $this->validator->initialize($this->executionContext);
    }

    public function testSimpleValidate()
    {
        $constraint = new BlacklistedDomain();

        $this->executionContext
            ->expects($this->never())
            ->method('addViolation');

        $this->validator->validate(null, $constraint);
        $this->validator->validate('', $constraint);
        $this->validator->validate(' ', $constraint);
    }

    public function testValidateWithoutException()
    {
        $value = 'http://:80';
        $constraint = new BlacklistedDomain();

        $this->executionContext
            ->expects($this->never())
            ->method('addViolation');

        $this->parser
            ->expects($this->once())
            ->method('parseUrl')
            ->with($value)
            ->will($this->throwException(new InvalidArgumentException()));

        $this->validator->validate($value, $constraint);
    }

    public function testValidateWithObjectManagerMissing()
    {
        $constraint = new BlacklistedDomain();

        $this->executionContext
            ->expects($this->never())
            ->method('addViolation');

        $publicSuffix = 'com';
        $registerableDomain = 'example.com';
        $host = 'www.example.com';

        $parsed = (object) [
            'host' => (object) [
                'publicSuffix' => $publicSuffix,
                'registerableDomain' => $registerableDomain,
                'host' => $host,
            ],
        ];

        $this->parser
            ->expects($this->once())
            ->method('parseUrl')
            ->with('www.example.com')
            ->willReturn($parsed);

        $repository = $this->createMock(ObjectRepository::class);

        $repository
            ->expects($this->once())
            ->method('findOneBy')
            ->with([
                'domain' => [
                    $publicSuffix,
                    $registerableDomain,
                    $host,
                ],
            ]);

        $this->objectManager
            ->expects($this->once())
            ->method('getRepository')
            ->willReturn($repository);

        $this->validator->validate('www.example.com', $constraint);
    }

    /**
     * @param array  $blockedHost
     * @param string $blockedLevel
     * @param string $blockedCategory
     * @param string $value
     *
     * @dataProvider objectManagerDataProvider
     */
    public function testValidateWithObjectManagerHit(array $blockedHost, $blockedLevel, $blockedCategory, $value)
    {
        $constraint = new BlacklistedDomain();

        $this->executionContext
            ->expects($this->once())
            ->method('addViolation')
            ->with($constraint->message, [
                '%category%' => $blockedCategory,
                '%domain%' => $blockedHost[$blockedLevel],
                '%value%' => $value,
            ]);

        $parsed = (object) [
            'host' => (object) $blockedHost,
        ];

        $this->parser
            ->expects($this->once())
            ->method('parseUrl')
            ->with($value)
            ->willReturn($parsed);

        $domain = new Domain();
        $domain->setDomain($blockedHost[$blockedLevel]);
        $domain->setCategory($blockedCategory);

        $repository = $this->createMock(ObjectRepository::class);

        $repository
            ->expects($this->once())
            ->method('findOneBy')
            ->with([
                'domain' => array_values($blockedHost),
            ])
            ->willReturn($domain);

        $this->objectManager
            ->expects($this->once())
            ->method('getRepository')
            ->willReturn($repository);

        $this->validator->validate($value, $constraint);
    }

    public static function objectManagerDataProvider()
    {
        yield [
            [
                'publicSuffix' => 'com',
                'registerableDomain' => 'example.com',
                'host' => 'www.example.com',
            ],
            'publicSuffix',
            'test1',
            'www.example.com',
        ];
        yield [
            [
                'publicSuffix' => 'com',
                'registerableDomain' => 'example.com',
                'host' => 'www.example.com',
            ],
            'registerableDomain',
            'test2',
            'www.example.com',
        ];
        yield [
            [
                'publicSuffix' => 'com',
                'registerableDomain' => 'example.com',
                'host' => 'www.example.com',
            ],
            'host',
            'test3',
            'www.example.com',
        ];
    }
}
