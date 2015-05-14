" phpnamespace - Composer namepspace generator
"
" Author: Daniel Leech <daniel@dantleech.com>

let s:genpath = expand('<sfile>:p:h') . '/../lib/namespaces.php'

function! PhpNamespaceGet()
    let currentPath = expand('%')
    let namespace = system('php ' . s:genpath . ' ' . currentPath)
    
    if (v:shell_error == 0)
        return namespace
    else 
        echoerr namespace
    endif
endfunction


function! PhpNamespaceInsert()
    exec "normal! i" . PhpNamespaceGet()
endfunction
