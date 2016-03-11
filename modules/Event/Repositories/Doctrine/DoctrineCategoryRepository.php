<?php namespace Modules\Event\Repositories\Doctrine;

use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use Modules\Event\Repositories\CategoryRepository;

class DoctrineCategoryRepository implements CategoryRepository {

    protected $genericRepository;

    public function __construct(NestedTreeRepository $genericRepository) {
        $this->genericRepository = $genericRepository;
    }

    /**
     * Retrieves the nested array or the decorated output.
     *
     * Uses options to handle decorations
     *
     * @throws \Gedmo\Exception\InvalidArgumentException
     *
     * @param object  $node        - from which node to start reordering the tree
     * @param boolean $direct      - true to take only direct children
     * @param array   $options     :
     *                             decorate: boolean (false) - retrieves tree as UL->LI tree
     *                             nodeDecorator: Closure (null) - uses $node as argument and returns decorated item as string
     *                             rootOpen: string || Closure ('<ul>') - branch start, closure will be given $children as a parameter
     *                             rootClose: string ('</ul>') - branch close
     *                             childStart: string || Closure ('<li>') - start of node, closure will be given $node as a parameter
     *                             childClose: string ('</li>') - close of node
     *                             childSort: array || keys allowed: field: field to sort on, dir: direction. 'asc' or 'desc'
     * @param boolean $includeNode - Include node on results?
     *
     * @return array|string
     */
    public function childrenHierarchy($node = null, $direct = false, array $options = array(), $includeNode = false) {
        return $this->genericRepository->childrenHierarchy($node,$direct,$options,$includeNode);
    }

    /**
     * Retrieves the nested array or the decorated output.
     *
     * Uses options to handle decorations
     * NOTE: nodes should be fetched and hydrated as array
     *
     * @throws \Gedmo\Exception\InvalidArgumentException
     *
     * @param array $nodes   - list o nodes to build tree
     * @param array $options :
     *                       decorate: boolean (false) - retrieves tree as UL->LI tree
     *                       nodeDecorator: Closure (null) - uses $node as argument and returns decorated item as string
     *                       rootOpen: string || Closure ('<ul>') - branch start, closure will be given $children as a parameter
     *                       rootClose: string ('</ul>') - branch close
     *                       childStart: string || Closure ('<li>') - start of node, closure will be given $node as a parameter
     *                       childClose: string ('</li>') - close of node
     *
     * @return array|string
     */
    public function buildTree(array $nodes, array $options = array()) {
        return $this->genericRepository->buildTree($nodes,$options);
    }

    /**
     * Process nodes and produce an array with the
     * structure of the tree
     *
     * @param array $nodes - Array of nodes
     *
     * @return array - Array with tree structure
     */
    public function buildTreeArray(array $nodes) {
        return $this->genericRepository->buildTreeArray($nodes);
    }

    /**
     * Sets the current children index.
     *
     * @param string $childrenIndex
     */
    public function setChildrenIndex($childrenIndex) {
        $this->genericRepository->setChildrenIndex($childrenIndex);
    }

    /**
     * Gets the current children index.
     *
     * @return string
     */
    public function getChildrenIndex() {
        return $this->genericRepository->getChildrenIndex();
    }

    /**
     * Get all root nodes
     *
     * @param string $sortByField
     * @param string $direction
     *
     * @return array
     */
    public function getRootNodes($sortByField = null, $direction = 'asc') {
        return $this->genericRepository->getRootNodes($sortByField,$direction);
    }

    /**
     * Returns an array of nodes suitable for method buildTree
     *
     * @param object  $node        - Root node
     * @param bool    $direct      - Obtain direct children?
     * @param array   $options     - Options
     * @param boolean $includeNode - Include node in results?
     *
     * @return array - Array of nodes
     */
    public function getNodesHierarchy($node = null, $direct = false, array $options = array(), $includeNode = false) {
        return $this->genericRepository->getNodesHierarchy($node,$direct,$options,$includeNode);
    }

    /**
     * Get list of children followed by given $node
     *
     * @param object  $node        - if null, all tree nodes will be taken
     * @param boolean $direct      - true to take only direct children
     * @param string  $sortByField - field name to sort by
     * @param string  $direction   - sort direction : "ASC" or "DESC"
     * @param bool    $includeNode - Include the root node in results?
     *
     * @return array - list of given $node children, null on failure
     */
    public function getChildren($node = null, $direct = false, $sortByField = null, $direction = 'ASC', $includeNode = false) {
        return $this->genericRepository->getChildren($node,$direct,$sortByField,$direction,$includeNode);
    }

    /**
     * Counts the children of given TreeNode
     *
     * @param object  $node   - if null counts all records in tree
     * @param boolean $direct - true to count only direct children
     *
     * @throws \Gedmo\Exception\InvalidArgumentException - if input is not valid
     *
     * @return integer
     */
    public function childCount($node = null, $direct = false) {
        return $this->genericRepository->childCount($node,$direct);
    }

    public function findByMachineName($machineName) {
        return $this->genericRepository->findOneByMachineName($machineName);
    }

}