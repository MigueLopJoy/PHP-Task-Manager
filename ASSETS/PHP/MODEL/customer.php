<?php

class Customer implements JsonSerializable {
    private int $customerId;
    private string $firstName;
    private string $surName;
    private string $email;
    private string $phoneNumber;

    public function __construct(string $firstName, string $surName, string $email, string $phoneNumber) {
        $this->firstName = $firstName;
        $this->surName = $surName;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
    }

    public function getCustomerId(): int {
        return $this->customerId;
    }

    public function getFirstName(): string {
        return $this->firstName;
    }

    public function getSurName(): string {
        return $this->surName;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPhoneNumber(): string {
        return $this->phoneNumber;
    }

    public function setFirstName(string $firstName): void {
        $this->firstName = $firstName;
    }

    public function setSurName(string $surName): void {
        $this->surName = $surName;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function setPhoneNumber(string $phoneNumber): void {
        $this->phoneNumber = $phoneNumber;
    }

    public function jsonSerialize(): mixed {
        return [
            $this->firstName,
            $this->surName,
            $this->email,         
            $this->phoneNumber
        ];
    }
}

?>
