// // The editor creator to use.
// import { ClassicEditor as ClassicEditorBase } from '../../ckeditor5/node_modules/@ckeditor/ckeditor5-editor-classic';
//
// import { UploadAdapter } from '../../ckeditor5/node_modules/@ckeditor/ckeditor5-adapter-ckfinder';
// import { Autoformat } from '../../ckeditor5/node_modules/@ckeditor/ckeditor5-autoformat';
// import { Bold, Italic } from '../../ckeditor5/node_modules/@ckeditor/ckeditor5-basic-styles';
// import { BlockQuote } from '../../ckeditor5/node_modules/@ckeditor/ckeditor5-block-quote';
// import { EasyImage } from '../../ckeditor5/node_modules/@ckeditor/ckeditor5-easy-image';
// import { Essentials } from '../../ckeditor5/node_modules/@ckeditor/ckeditor5-essentials';
// import { Heading } from '../../ckeditor5/node_modules/@ckeditor/ckeditor5-heading';
// import { Image, ImageCaption, ImageStyle, ImageToolbar, ImageUpload } from '../../ckeditor5/node_modules/@ckeditor/ckeditor5-image';
// import { Link } from '../../ckeditor5/node_modules/@ckeditor/ckeditor5-link';
// import { List } from '../../ckeditor5/node_modules/@ckeditor/ckeditor5-list';
// import { Paragraph } from '../../ckeditor5/node_modules/@ckeditor/ckeditor5-paragraph';
//
// import { Alignment } from '../../ckeditor5/node_modules/@ckeditor/ckeditor5-alignment'; // <--- ADDED
//
// export default class ClassicEditor extends ClassicEditorBase {}
//
// // Plugins to include in the build.
// ClassicEditor.builtinPlugins = [
//     Essentials,
//     UploadAdapter,
//     Autoformat,
//     Bold,
//     Italic,
//     BlockQuote,
//     EasyImage,
//     Heading,
//     Image,
//     ImageCaption,
//     ImageStyle,
//     ImageToolbar,
//     ImageUpload,
//     Link,
//     List,
//     Paragraph,
//     Alignment                                                            // <--- ADDED
// ];
//
// // Editor configuration.
// ClassicEditor.defaultConfig = {
//     toolbar: {
//         items: [
//             'heading',
//             '|',
//             'alignment',                                                 // <--- ADDED
//             'bold',
//             'italic',
//             'link',
//             'bulletedList',
//             'numberedList',
//             'uploadImage',
//             'blockQuote',
//             'undo',
//             'redo'
//         ]
//     },
//     image: {
//         toolbar: [
//             'imageStyle:inline',
//             'imageStyle:block',
//             'imageStyle:side',
//             '|',
//             'toggleImageCaption',
//             'imageTextAlternative'
//         ]
//     },
//     // This value must be kept in sync with the language defined in webpack.config.js.
//     language: 'en'
// };
