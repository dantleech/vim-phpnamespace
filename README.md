Vim Namespace
=============

Plugin which guesses the namespace of the current file from `composer.json`.

Note that the algorithm for determining the namespace is not 100% accurate
(although it could be) but it should work in the majority of cases.

It should work with both `psr-0` and `psr-4` projects.

Installation
------------

With Vundle:

````vim
Plugin "dantleech/vim-phpnamespace"
````

Usage
-----

Map it:

````vim
nnoremap <silent><leader>nn :call PhpNamespaceInsert()<CR>
````

Call it:

````vim
let s:foo = PhpNamespaceGet()
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
