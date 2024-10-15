import{B as W,a9 as j,a$ as $,D,b1 as K,M as E,b as a,K as b,at as Q,b7 as X,bu as Y,bi as G,ac as J,aQ as Z,b0 as p,ae as m,r as ee,a1 as P,bX as te,bY as ae,aE as re,bn as ne,x as N,aU as le,F as ie,P as se,b4 as oe,an as ue,bl as _}from"./main-DRbHMMTA.js";function ce(e){return{aspectStyles:b(()=>{const c=Number(e.aspectRatio);return c?{paddingBottom:String(1/c*100)+"%"}:void 0})}}const x=W({aspectRatio:[String,Number],contentClass:null,inline:Boolean,...j(),...$()},"VResponsive"),F=D()({name:"VResponsive",props:x(),setup(e,c){let{slots:o}=c;const{aspectStyles:s}=ce(e),{dimensionStyles:h}=K(e);return E(()=>{var f;return a("div",{class:["v-responsive",{"v-responsive--inline":e.inline},e.class],style:[h.value,e.style]},[a("div",{class:"v-responsive__sizer",style:s.value},null),(f=o.additional)==null?void 0:f.call(o),o.default&&a("div",{class:["v-responsive__content",e.contentClass]},[o.default()])])}),{}}}),de=W({alt:String,cover:Boolean,color:String,draggable:{type:[Boolean,String],default:void 0},eager:Boolean,gradient:String,lazySrc:String,options:{type:Object,default:()=>({root:void 0,rootMargin:void 0,threshold:void 0})},sizes:String,src:{type:[String,Object],default:""},crossorigin:String,referrerpolicy:String,srcset:String,position:String,...x(),...j(),...Q(),...X()},"VImg"),ge=D()({name:"VImg",directives:{intersect:Y},props:de(),emits:{loadstart:e=>!0,load:e=>!0,error:e=>!0},setup(e,c){let{emit:o,slots:s}=c;const{backgroundColorClasses:h,backgroundColorStyles:f}=G(J(e,"color")),{roundedClasses:M}=Z(e),S=p("VImg"),C=m(""),l=ee(),n=m(e.eager?"loading":"idle"),d=m(),y=m(),i=b(()=>e.src&&typeof e.src=="object"?{src:e.src.src,srcset:e.srcset||e.src.srcset,lazySrc:e.lazySrc||e.src.lazySrc,aspect:Number(e.aspectRatio||e.src.aspect||0)}:{src:e.src,srcset:e.srcset,lazySrc:e.lazySrc,aspect:Number(e.aspectRatio||0)}),v=b(()=>i.value.aspect||d.value/y.value||0);P(()=>e.src,()=>{R(n.value!=="idle")}),P(v,(t,r)=>{!t&&r&&l.value&&g(l.value)}),te(()=>R());function R(t){if(!(e.eager&&t)&&!(ae&&!t&&!e.eager)){if(n.value="loading",i.value.lazySrc){const r=new Image;r.src=i.value.lazySrc,g(r,null)}i.value.src&&re(()=>{var r;o("loadstart",((r=l.value)==null?void 0:r.currentSrc)||i.value.src),setTimeout(()=>{var u;if(!S.isUnmounted)if((u=l.value)!=null&&u.complete){if(l.value.naturalWidth||k(),n.value==="error")return;v.value||g(l.value,null),n.value==="loading"&&I()}else v.value||g(l.value),T()})})}}function I(){var t;S.isUnmounted||(T(),g(l.value),n.value="loaded",o("load",((t=l.value)==null?void 0:t.currentSrc)||i.value.src))}function k(){var t;S.isUnmounted||(n.value="error",o("error",((t=l.value)==null?void 0:t.currentSrc)||i.value.src))}function T(){const t=l.value;t&&(C.value=t.currentSrc||t.src)}let z=-1;ne(()=>{clearTimeout(z)});function g(t){let r=arguments.length>1&&arguments[1]!==void 0?arguments[1]:100;const u=()=>{if(clearTimeout(z),S.isUnmounted)return;const{naturalHeight:B,naturalWidth:U}=t;B||U?(d.value=U,y.value=B):!t.complete&&n.value==="loading"&&r!=null?z=window.setTimeout(u,r):(t.currentSrc.endsWith(".svg")||t.currentSrc.startsWith("data:image/svg+xml"))&&(d.value=1,y.value=1)};u()}const V=b(()=>({"v-img__img--cover":e.cover,"v-img__img--contain":!e.cover})),O=()=>{var u;if(!i.value.src||n.value==="idle")return null;const t=a("img",{class:["v-img__img",V.value],style:{objectPosition:e.position},src:i.value.src,srcset:i.value.srcset,alt:e.alt,crossorigin:e.crossorigin,referrerpolicy:e.referrerpolicy,draggable:e.draggable,sizes:e.sizes,ref:l,onLoad:I,onError:k},null),r=(u=s.sources)==null?void 0:u.call(s);return a(_,{transition:e.transition,appear:!0},{default:()=>[N(r?a("picture",{class:"v-img__picture"},[r,t]):t,[[ue,n.value==="loaded"]])]})},A=()=>a(_,{transition:e.transition},{default:()=>[i.value.lazySrc&&n.value!=="loaded"&&a("img",{class:["v-img__img","v-img__img--preload",V.value],style:{objectPosition:e.position},src:i.value.lazySrc,alt:e.alt,crossorigin:e.crossorigin,referrerpolicy:e.referrerpolicy,draggable:e.draggable},null)]}),H=()=>s.placeholder?a(_,{transition:e.transition,appear:!0},{default:()=>[(n.value==="loading"||n.value==="error"&&!s.error)&&a("div",{class:"v-img__placeholder"},[s.placeholder()])]}):null,q=()=>s.error?a(_,{transition:e.transition,appear:!0},{default:()=>[n.value==="error"&&a("div",{class:"v-img__error"},[s.error()])]}):null,L=()=>e.gradient?a("div",{class:"v-img__gradient",style:{backgroundImage:`linear-gradient(${e.gradient})`}},null):null,w=m(!1);{const t=P(v,r=>{r&&(requestAnimationFrame(()=>{requestAnimationFrame(()=>{w.value=!0})}),t())})}return E(()=>{const t=F.filterProps(e);return N(a(F,se({class:["v-img",{"v-img--booting":!w.value},h.value,M.value,e.class],style:[{width:oe(e.width==="auto"?d.value:e.width)},f.value,e.style]},t,{aspectRatio:v.value,"aria-label":e.alt,role:e.alt?"img":void 0}),{additional:()=>a(ie,null,[a(O,null,null),a(A,null,null),a(L,null,null),a(H,null,null),a(q,null,null)]),default:s.default}),[[le("intersect"),{handler:R,options:e.options},null,{once:!0}]])}),{currentSrc:C,image:l,state:n,naturalWidth:d,naturalHeight:y}}});export{ge as V};
