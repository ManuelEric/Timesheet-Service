import{B as S,ap as V,a9 as h,bh as x,at as P,aa as N,av as T,b7 as R,D as _,bi as w,ac as d,aQ as L,ax as A,bf as D,a6 as I,bj as M,M as X,bk as Y,b as t,bl as $,x as j,an as F,P as u,V as Q}from"./main-C_ZsSyxB.js";const W=S({bordered:Boolean,color:String,content:[Number,String],dot:Boolean,floating:Boolean,icon:V,inline:Boolean,label:{type:String,default:"$vuetify.badge"},max:[Number,String],modelValue:{type:Boolean,default:!0},offsetX:[Number,String],offsetY:[Number,String],textColor:String,...h(),...x({location:"top end"}),...P(),...N(),...T(),...R({transition:"scale-rotate-transition"})},"VBadge"),z=_()({name:"VBadge",inheritAttrs:!1,props:W(),setup(e,o){const{backgroundColorClasses:c,backgroundColorStyles:b}=w(d(e,"color")),{roundedClasses:g}=L(e),{t:m}=A(),{textColorClasses:f,textColorStyles:v}=D(d(e,"textColor")),{themeClasses:C}=I(),{locationStyles:k}=M(e,!0,a=>(e.floating?e.dot?2:4:e.dot?8:12)+(["top","bottom"].includes(a)?+(e.offsetY??0):["left","right"].includes(a)?+(e.offsetX??0):0));return X(()=>{const a=Number(e.content),n=!e.max||isNaN(a)?e.content:a<=+e.max?a:`${e.max}+`,[y,B]=Y(o.attrs,["aria-atomic","aria-label","aria-live","role","title"]);return t(e.tag,u({class:["v-badge",{"v-badge--bordered":e.bordered,"v-badge--dot":e.dot,"v-badge--floating":e.floating,"v-badge--inline":e.inline},e.class]},B,{style:e.style}),{default:()=>{var s,l;return[t("div",{class:"v-badge__wrapper"},[(l=(s=o.slots).default)==null?void 0:l.call(s),t($,{transition:e.transition},{default:()=>{var i,r;return[j(t("span",u({class:["v-badge__badge",C.value,c.value,g.value,f.value],style:[b.value,v.value,e.inline?{}:k.value],"aria-atomic":"true","aria-label":m(e.label,a),"aria-live":"polite",role:"status"},y),[e.dot?void 0:o.slots.badge?(r=(i=o.slots).badge)==null?void 0:r.call(i):e.icon?t(Q,{icon:e.icon},null):n]),[[F,e.modelValue]])]}})])]}})}),{}}});export{z as V};
