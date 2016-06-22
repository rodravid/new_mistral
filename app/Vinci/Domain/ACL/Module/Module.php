<?php

namespace Vinci\Domain\ACL\Module;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;
use Vinci\Domain\Core\Model;
use Vinci\Domain\User\User;

/**
 * @Gedmo\Tree(type="nested")
 * @ORM\Entity
 */
class Module extends Model
{

    use Timestamps;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $url;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $datatable_url;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $icon;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $create_button_text;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $editing_text;

    /**
     * @ORM\ManyToMany(targetEntity="Vinci\Domain\ACL\Role\Role", mappedBy="modules")
     */
    protected $roles;

    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer")
     */
    protected $lft;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer")
     */
    protected $lvl;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer")
     */
    protected $rgt;

    /**
     * @Gedmo\TreeRoot
     * @ORM\ManyToOne(targetEntity="Module")
     * @ORM\JoinColumn(name="tree_root", referencedColumnName="id", onDelete="CASCADE")
     */
    private $root;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Module", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Module", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setDatatableUrl($url)
    {
        $this->datatable_url = $url;
    }

    public function getDatatableUrl()
    {
        return $this->datatable_url;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    public function getIcon()
    {
        return $this->icon;
    }

    public function getRoot()
    {
        return $this->root;
    }

    public function setParent(Module $parent = null)
    {
        $this->parent = $parent;
        return $this;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function hasParent()
    {
        return $this->getParent() instanceof Module;
    }

    public function setChildrens($childs)
    {
        $this->children = $childs;
    }

    public function getChildrens()
    {
        return $this->children;
    }

    public function canBeManagedBy(User $user)
    {
        foreach ($user->getRoles() as $role) {

            if ($this->roles->contains($role)) {
                return true;
            }
        }

        return false;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function hasChildrens()
    {
        return $this->children->count() > 0;
    }
    
    public function getLft()
    {
        return $this->lft;
    }

    public function getLvl()
    {
        return $this->lvl;
    }

    public function getRgt()
    {
        return $this->rgt;
    }

    public function setCreateButtonText($create_button_text)
    {
        $this->create_button_text = $create_button_text;
        return $this;
    }

    public function getCreateButtonText()
    {
        return $this->create_button_text;
    }

    public function getEditingText()
    {
        return $this->editing_text;
    }

    public function setEditingText($editing_text)
    {
        $this->editing_text = $editing_text;
        return $this;
    }

}