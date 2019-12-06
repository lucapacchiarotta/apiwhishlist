<?php
namespace Api\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Wishlist
 *
 * @ORM\Table(name="list")
 * @ORM\Entity
 */
class Wishlist {
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="text", nullable=false)
     */
    private $name;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="items", type="text", nullable=true)
     */
    private $items;
    
    /**
     * @var string
     *
     * @ORM\Column(name="user", type="text", nullable=false)
     */
    private $user;
    
    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }
    /**
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
    }
    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }
    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }
    /**
     * @return string
     */
    public function getItems() {
        return $this->items;
    }
    /**
     * @param string $items
     */
    public function setItems($items) {
        $this->items = $items;
    }
    /**
     * @return string
     */
    public function getUser() {
        return $this->user;
    }
    /**
     * @param string $user
     */
    public function setUser($user) {
        $this->user = $user;
    }
}