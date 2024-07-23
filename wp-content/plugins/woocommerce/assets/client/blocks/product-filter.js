(()=>{var e,t,o,r={7666:(e,t,o)=>{"use strict";o.r(t);var r=o(1609);const c=window.wp.blocks;var i=o(7104),l=o(6215),n=o(3576),a=o(885),s=o(6378),m=o(846);const p=window.wc.wcSettings;var u=o(7723),d=o(5573);const f=(0,r.createElement)(d.SVG,{xmlns:"http://www.w3.org/2000/SVG",viewBox:"0 0 24 24"},(0,r.createElement)("path",{fill:"none",d:"M0 0h24v24H0z"}),(0,r.createElement)("path",{d:"M17 6H7c-3.31 0-6 2.69-6 6s2.69 6 6 6h10c3.31 0 6-2.69 6-6s-2.69-6-6-6zm0 10H7c-2.21 0-4-1.79-4-4s1.79-4 4-4h10c2.21 0 4 1.79 4 4s-1.79 4-4 4zm0-7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"})),w=JSON.parse('{"name":"woocommerce/product-filter","version":"1.0.0","title":"Product Filter (Experimental)","description":"A block that adds product filters to the product collection.","category":"woocommerce","keywords":["WooCommerce","Filters"],"textdomain":"woocommerce","supports":{"html":false,"reusable":false,"inserter":false},"usesContext":["query","queryId"],"attributes":{"filterType":{"type":"string"},"heading":{"type":"string"},"isPreview":{"type":"boolean","default":false},"attributeId":{"type":"number","default":0}},"example":{"attributes":{"isPreview":true}},"apiVersion":2,"$schema":"https://schemas.wp.org/trunk/block.json"}'),b=window.wp.blockEditor,g=window.wp.data,k=window.wp.components,y=()=>(0,p.getSetting)("isWidgetEditor")?(0,r.createElement)(k.Notice,{status:"info",isDismissible:!1},(0,u.__)("The widget area containing Collection Filters block needs to be placed on a product archive page for filters to function properly.","woocommerce")):(0,p.getSetting)("isSiteEditor")?null:(0,r.createElement)(k.Notice,{status:"warning",isDismissible:!1},(0,u.__)("When added to a post or page, Collection Filters block needs to be nested inside a Product Collection block to function properly.","woocommerce"));o(1472);const v={"active-filters":"woocommerce/product-filter-active","price-filter":"woocommerce/product-filter-price","stock-filter":"woocommerce/product-filter-stock-status","rating-filter":"woocommerce/product-filter-rating","attribute-filter":"woocommerce/product-filter-attribute"};(()=>{const{experimentalBlocksEnabled:e}=(0,p.getSetting)("wcBlocksConfig",{experimentalBlocksEnabled:!1});return e})()&&(0,c.registerBlockType)(w,{icon:{src:(0,r.createElement)(i.A,{icon:l.A,className:"wc-block-editor-components-block-icon"})},edit:({attributes:e,clientId:t})=>{const o=(0,b.useBlockProps)(),i=(0,g.useSelect)((e=>{const{getBlockParentsByBlockName:o}=e("core/block-editor");return!!o(t,"woocommerce/product-collection").length}));return(0,r.createElement)("nav",{...o},!i&&(0,r.createElement)(y,null),(0,r.createElement)(b.InnerBlocks,{allowedBlocks:(l=[...Object.values(v),"woocommerce/product-filter","woocommerce/filter-wrapper","woocommerce/product-collection","core/query"],(0,c.getBlockTypes)().map((e=>e.name)).filter((e=>!l.includes(e)))),template:["active-filters"===e.filterType?["core/heading",{level:3,content:e.heading||""}]:["core/group",{layout:{type:"flex",flexWrap:"nowrap"},metadata:{name:(0,u.__)("Header","woocommerce")},style:{spacing:{blockGap:"0"}}},[["core/heading",{level:3,content:e.heading||""}],["woocommerce/product-filter-clear-button",{lock:{remove:!0,move:!1}}]]],[v[e.filterType],{lock:{remove:!0},isPreview:e.isPreview,attributeId:"attribute-filter"===e.filterType&&e.attributeId?e.attributeId:void 0}]]}));var l},save:function(){return(0,r.createElement)(b.InnerBlocks.Content,null)},variations:[{name:"product-filter-active",title:(0,u.__)("Product Filter: Active Filters (Experimental)","woocommerce"),description:(0,u.__)("Display the currently active filters.","woocommerce"),attributes:{heading:(0,u.__)("Active filters","woocommerce"),filterType:"active-filters"},icon:{src:(0,r.createElement)(i.A,{icon:f,className:"wc-block-editor-components-block-icon"})},isDefault:!0},{name:"product-filter-price",title:(0,u.__)("Product Filter: Price (Experimental)","woocommerce"),description:(0,u.__)("Enable customers to filter the product collection by choosing a price range.","woocommerce"),attributes:{filterType:"price-filter",heading:(0,u.__)("Filter by Price","woocommerce")},icon:{src:(0,r.createElement)(i.A,{icon:n.A,className:"wc-block-editor-components-block-icon"})}},{name:"product-filter-stock-status",title:(0,u.__)("Product Filter: Stock Status (Experimental)","woocommerce"),description:(0,u.__)("Enable customers to filter the product collection by stock status.","woocommerce"),attributes:{filterType:"stock-filter",heading:(0,u.__)("Filter by Stock Status","woocommerce")},icon:{src:(0,r.createElement)(i.A,{icon:a.A,className:"wc-block-editor-components-block-icon"})}},{name:"product-filter-attribute",title:(0,u.__)("Product Filter: Attribute (Experimental)","woocommerce"),description:(0,u.__)("Enable customers to filter the product collection by selecting one or more attributes, such as color.","woocommerce"),attributes:{filterType:"attribute-filter",heading:(0,u.__)("Filter by Attribute","woocommerce")},icon:{src:(0,r.createElement)(i.A,{icon:s.A,className:"wc-block-editor-components-block-icon"})}},{name:"product-filter-rating",title:(0,u.__)("Product Filter: Rating (Experimental)","woocommerce"),description:(0,u.__)("Enable customers to filter the product collection by rating.","woocommerce"),attributes:{filterType:"rating-filter",heading:(0,u.__)("Filter by Rating","woocommerce")},icon:{src:(0,r.createElement)(i.A,{icon:m.A,className:"wc-block-editor-components-block-icon"})}}],transforms:{from:[{type:"block",blocks:["woocommerce/filter-wrapper"],transform:(e,t)=>{const o=[];return t.forEach((t=>{t.name===`woocommerce/${e.filterType}`&&o.push((0,c.createBlock)(v[e.filterType],t.attributes)),"core/heading"===t.name&&o.push(t)})),(0,c.createBlock)("woocommerce/product-filter",e,o)}}]}})},1472:()=>{},1609:e=>{"use strict";e.exports=window.React},6087:e=>{"use strict";e.exports=window.wp.element},7723:e=>{"use strict";e.exports=window.wp.i18n},5573:e=>{"use strict";e.exports=window.wp.primitives}},c={};function i(e){var t=c[e];if(void 0!==t)return t.exports;var o=c[e]={exports:{}};return r[e].call(o.exports,o,o.exports,i),o.exports}i.m=r,e=[],i.O=(t,o,r,c)=>{if(!o){var l=1/0;for(m=0;m<e.length;m++){for(var[o,r,c]=e[m],n=!0,a=0;a<o.length;a++)(!1&c||l>=c)&&Object.keys(i.O).every((e=>i.O[e](o[a])))?o.splice(a--,1):(n=!1,c<l&&(l=c));if(n){e.splice(m--,1);var s=r();void 0!==s&&(t=s)}}return t}c=c||0;for(var m=e.length;m>0&&e[m-1][2]>c;m--)e[m]=e[m-1];e[m]=[o,r,c]},i.n=e=>{var t=e&&e.__esModule?()=>e.default:()=>e;return i.d(t,{a:t}),t},o=Object.getPrototypeOf?e=>Object.getPrototypeOf(e):e=>e.__proto__,i.t=function(e,r){if(1&r&&(e=this(e)),8&r)return e;if("object"==typeof e&&e){if(4&r&&e.__esModule)return e;if(16&r&&"function"==typeof e.then)return e}var c=Object.create(null);i.r(c);var l={};t=t||[null,o({}),o([]),o(o)];for(var n=2&r&&e;"object"==typeof n&&!~t.indexOf(n);n=o(n))Object.getOwnPropertyNames(n).forEach((t=>l[t]=()=>e[t]));return l.default=()=>e,i.d(c,l),c},i.d=(e,t)=>{for(var o in t)i.o(t,o)&&!i.o(e,o)&&Object.defineProperty(e,o,{enumerable:!0,get:t[o]})},i.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),i.r=e=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},i.j=7719,(()=>{var e={7719:0};i.O.j=t=>0===e[t];var t=(t,o)=>{var r,c,[l,n,a]=o,s=0;if(l.some((t=>0!==e[t]))){for(r in n)i.o(n,r)&&(i.m[r]=n[r]);if(a)var m=a(i)}for(t&&t(o);s<l.length;s++)c=l[s],i.o(e,c)&&e[c]&&e[c][0](),e[c]=0;return i.O(m)},o=self.webpackChunkwebpackWcBlocksMainJsonp=self.webpackChunkwebpackWcBlocksMainJsonp||[];o.forEach(t.bind(null,0)),o.push=t.bind(null,o.push.bind(o))})();var l=i.O(void 0,[94],(()=>i(7666)));l=i.O(l),((this.wc=this.wc||{}).blocks=this.wc.blocks||{})["product-filter"]=l})();