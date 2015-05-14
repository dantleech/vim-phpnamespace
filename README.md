Vim Namespace
=============

Plugin which guesses the namespace of the current file from `composer.json`.

Note that the algorithm for determining the namespace could be improved,
although it should currently work in most cases.

Installation
------------

With Vundle:

````vim
Plugin "dantleech/vim-phpnamespace"
````

Mapping
-------

````vim
nnoremap <silent><leader>nn :call PhpNamespaceInsert<CR>
````

Integration with Ultisnips
--------------------------

Use it with ultisnips to generate class / interface templates:

````vim
snippet interface "Interface declaration template" !b
<?php

namespace ${1:`!v PhpNamespaceGet()`};

interface ${1:`!v expand("%:t:r")`}
{
    $0;
}
endsnippet

snippet class "Class declaration template" !b
<?php

namespace ${1:`!v PhpNamespaceGet()`};

class ${1:`!v expand("%:t:r")`}
{
    $0;
}
endsnippet
````
