import{B as S,$ as V,a0 as h,a4 as P,a6 as x,a7 as N,a8 as T,aJ as R,D as L,aK as _,aj as d,ah as w,ak as I,ai as M,au as $,af as A,M as D,aL as X,b as t,aM as Y,x as j,aI as F,P as u,V as J}from"./main-zVU3Tu4j.js";const K=S({bordered:Boolean,color:String,content:[Number,String],dot:Boolean,floating:Boolean,icon:V,inline:Boolean,label:{type:String,default:"$vuetify.badge"},max:[Number,String],modelValue:{type:Boolean,default:!0},offsetX:[Number,String],offsetY:[Number,String],textColor:String,...h(),...P({location:"top end"}),...x(),...N(),...T(),...R({transition:"scale-rotate-transition"})},"VBadge"),q=L()({name:"VBadge",inheritAttrs:!1,props:K(),setup(e,o){const{backgroundColorClasses:c,backgroundColorStyles:g}=_(d(e,"color")),{roundedClasses:b}=w(e),{t:m}=I(),{textColorClasses:f,textColorStyles:v}=M(d(e,"textColor")),{themeClasses:C}=$(),{locationStyles:k}=A(e,!0,a=>(e.floating?e.dot?2:4:e.dot?8:12)+(["top","bottom"].includes(a)?+(e.offsetY??0):["left","right"].includes(a)?+(e.offsetX??0):0));return D(()=>{const a=Number(e.content),n=!e.max||isNaN(a)?e.content:a<=+e.max?a:`${e.max}+`,[y,B]=X(o.attrs,["aria-atomic","aria-label","aria-live","role","title"]);return t(e.tag,u({class:["v-badge",{"v-badge--bordered":e.bordered,"v-badge--dot":e.dot,"v-badge--floating":e.floating,"v-badge--inline":e.inline},e.class]},B,{style:e.style}),{default:()=>{var s,l;return[t("div",{class:"v-badge__wrapper"},[(l=(s=o.slots).default)==null?void 0:l.call(s),t(Y,{transition:e.transition},{default:()=>{var i,r;return[j(t("span",u({class:["v-badge__badge",C.value,c.value,b.value,f.value],style:[g.value,v.value,e.inline?{}:k.value],"aria-atomic":"true","aria-label":m(e.label,a),"aria-live":"polite",role:"status"},y),[e.dot?void 0:o.slots.badge?(r=(i=o.slots).badge)==null?void 0:r.call(i):e.icon?t(J,{icon:e.icon},null):n]),[[F,e.modelValue]])]}})])]}})}),{}}});export{q as V};
