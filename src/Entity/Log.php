<?php

namespace App\Entity;

use App\Repository\LogRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table]
#[ORM\Entity(repositoryClass: LogRepository::class)]
class Log
{
    #[ORM\Column(name: 'id', type: Types::INTEGER)]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: Types::STRING)]
    private string $serviceName;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private DateTimeInterface $date;

    #[ORM\Column(type: Types::STRING)]
    private string $httpMethod;

    #[ORM\Column(type: Types::INTEGER)]
    private string $httpStatusCode;

    #[ORM\Column(type: Types::STRING)]
    private string $url;

    public function getId(): int
    {
        return $this->id;
    }

    public function getServiceName(): string
    {
        return $this->serviceName;
    }

    public function setServiceName(string $serviceName): static
    {
        $this->serviceName = $serviceName;
        return $this;
    }

    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(DateTimeInterface $date): static
    {
        $this->date = $date;
        return $this;
    }

    public function setDateString(string $date): static
    {
        $this->date = DateTime::createFromFormat('d/M/Y:H:i:s \+0000', $date);

        return $this;
    }

    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    public function setHttpMethod(string $httpMethod): static
    {
        $this->httpMethod = $httpMethod;
        return $this;
    }

    public function getHttpStatusCode(): string
    {
        return $this->httpStatusCode;
    }

    public function setHttpStatusCode(string $httpStatusCode): static
    {
        $this->httpStatusCode = $httpStatusCode;
        return $this;
    }

    public function setHttpStatusCodeString(string $httpStatusCode): static
    {
        $this->httpStatusCode = (int) $httpStatusCode;

        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;
        return $this;
    }
}