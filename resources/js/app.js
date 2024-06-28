import './bootstrap';
import './../../vendor/power-components/livewire-powergrid/dist/powergrid'
import './../../vendor/power-components/livewire-powergrid/dist/tailwind.css'

import Editor from '@toast-ui/editor'
import '@toast-ui/editor/dist/toastui-editor.css';

document.addEventListener('DOMContentLoaded', () => {
    const editor = new Editor({
        el: document.querySelector('#toastui-editor'),
        height: '400px',
        events: {
            change: (change) => {
                let content = document.querySelector('#toastui-content')
                content.value = editor.getHTML();
                content.dispatchEvent(new Event('input'));
            }
        },
        initialEditType: 'markdown',
        initialValue: document.querySelector('#toastui-content').value,
    });
});
