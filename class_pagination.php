class Pagination {
    protected $totalItems;
    protected $itemsPerPage;
    protected $currentPage;
    protected $baseUrl;

    public function __construct($totalItems, $itemsPerPage = 10, $currentPage = 1, $baseUrl = null) {
        $this->totalItems = $totalItems;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->baseUrl = $baseUrl;
    }

    public function getTotalPages() {
        return ceil($this->totalItems / $this->itemsPerPage);
    }

    public function getCurrentPage() {
        return $this->currentPage;
    }

    public function getOffset() {
        return ($this->currentPage - 1) * $this->itemsPerPage;
    }

    public function getPreviousPage() {
        return ($this->currentPage > 1) ? $this->currentPage - 1 : null;
    }

    public function getNextPage() {
        $totalPages = $this->getTotalPages();
        return ($this->currentPage < $totalPages) ? $this->currentPage + 1 : null;
    }

    public function generatePaginationLinks() {
        $totalPages = $this->getTotalPages();
        $paginationLinks = '<ul class="pagination">';
        
        if ($totalPages > 1) {
            if ($this->currentPage > 1) {
                $paginationLinks .= '<li><a href="' . $this->getPaginationLink($this->getPreviousPage()) . '">Previous</a></li>';
            }

            for ($i = 1; $i <= $totalPages; $i++) {
                if ($i == $this->currentPage) {
                    $paginationLinks .= '<li class="active"><span>' . $i . '</span></li>';
                } else {
                    $paginationLinks .= '<li><a href="' . $this->getPaginationLink($i) . '">' . $i . '</a></li>';
                }
            }

            if ($this->currentPage < $totalPages) {
                $paginationLinks .= '<li><a href="' . $this->getPaginationLink($this->getNextPage()) . '">Next</a></li>';
            }
        }
        
        $paginationLinks .= '</ul>';
        return $paginationLinks;
    }

    protected function getPaginationLink($page) {
        if ($this->baseUrl === null) {
            // If baseUrl is not provided, use the current page URL with the 'page' query parameter
            $baseUrl = $_SERVER['PHP_SELF'] . '?page=';
        } else {
            $baseUrl = rtrim($this->baseUrl, '/') . '/';
        }

        return $baseUrl . $page;
    }
}
