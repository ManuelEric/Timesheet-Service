import{B as m,a$ as P,as as S,av as h,D as f,bi as T,ac as B,b1 as C,aP as V,az as p,ax as w,K as L,b9 as _,M as k,b as i,P as D,a9 as A,ar as F,aa as $,aO as E,b4 as H}from"./main-C_ZsSyxB.js";const N={actions:"button@2",article:"heading, paragraph",avatar:"avatar",button:"button",card:"image, heading","card-avatar":"image, list-item-avatar",chip:"chip","date-picker":"list-item, heading, divider, date-picker-options, date-picker-days, actions","date-picker-options":"text, avatar@2","date-picker-days":"avatar@28",divider:"divider",heading:"heading",image:"image","list-item":"text","list-item-avatar":"avatar, text","list-item-two-line":"sentences","list-item-avatar-two-line":"avatar, sentences","list-item-three-line":"paragraph","list-item-avatar-three-line":"avatar, paragraph",ossein:"ossein",paragraph:"text@3",sentences:"text@2",subtitle:"text",table:"table-heading, table-thead, table-tbody, table-tfoot","table-heading":"chip, text","table-thead":"heading@6","table-tbody":"table-row-divider@6","table-row-divider":"table-row, divider","table-row":"text@6","table-tfoot":"text@2, avatar@2",text:"text"};function R(e){let t=arguments.length>1&&arguments[1]!==void 0?arguments[1]:[];return i("div",{class:["v-skeleton-loader__bone",`v-skeleton-loader__${e}`]},[t])}function b(e){const[t,a]=e.split("@");return Array.from({length:a}).map(()=>r(t))}function r(e){let t=[];if(!e)return t;const a=N[e];if(e!==a){if(e.includes(","))return g(e);if(e.includes("@"))return b(e);a.includes(",")?t=g(a):a.includes("@")?t=b(a):a&&t.push(r(a))}return[R(e,t)]}function g(e){return e.replace(/\s/g,"").split(",").map(r)}const j=m({boilerplate:Boolean,color:String,loading:Boolean,loadingText:{type:String,default:"$vuetify.loading"},type:{type:[String,Array],default:"ossein"},...P(),...S(),...h()},"VSkeletonLoader"),K=f()({name:"VSkeletonLoader",props:j(),setup(e,t){let{slots:a}=t;const{backgroundColorClasses:u,backgroundColorStyles:s}=T(B(e,"color")),{dimensionStyles:d}=C(e),{elevationClasses:n}=V(e),{themeClasses:o}=p(e),{t:l}=w(),x=L(()=>r(_(e.type).join(",")));return k(()=>{var v;const c=!a.default||e.loading,y=e.boilerplate||!c?{}:{ariaLive:"polite",ariaLabel:l(e.loadingText),role:"alert"};return i("div",D({class:["v-skeleton-loader",{"v-skeleton-loader--boilerplate":e.boilerplate},o.value,u.value,n.value],style:[s.value,c?d.value:{}]},y),[c?x.value:(v=a.default)==null?void 0:v.call(a)])}),{}}}),z=m({fixedHeader:Boolean,fixedFooter:Boolean,height:[Number,String],hover:Boolean,...A(),...F(),...$(),...h()},"VTable"),M=f()({name:"VTable",props:z(),setup(e,t){let{slots:a,emit:u}=t;const{themeClasses:s}=p(e),{densityClasses:d}=E(e);return k(()=>i(e.tag,{class:["v-table",{"v-table--fixed-height":!!e.height,"v-table--fixed-header":e.fixedHeader,"v-table--fixed-footer":e.fixedFooter,"v-table--has-top":!!a.top,"v-table--has-bottom":!!a.bottom,"v-table--hover":e.hover},s.value,d.value,e.class],style:e.style},{default:()=>{var n,o,l;return[(n=a.top)==null?void 0:n.call(a),a.default?i("div",{class:"v-table__wrapper",style:{height:H(e.height)}},[i("table",null,[a.default()])]):(o=a.wrapper)==null?void 0:o.call(a),(l=a.bottom)==null?void 0:l.call(a)]}})),{}}});export{K as V,M as a};
