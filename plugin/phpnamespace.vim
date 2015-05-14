" phpnamespace - Composer namepspace generator
"
" Author: Daniel Leech <daniel@dantleech.com>

let s:genpath = expand('<sfile>:p:h') . '/../lib/namespaces.php'

function! PhpNamespaceGenerate()
    let currentPath = expand('%:p')
    let namespace = system('php ' . s:genpath . ' ' . currentPath)
    
    if (v:shell_error == 0)
        call append(line('.'), namespace)
    else 
        echoerr namespace
    endif
endfunction
