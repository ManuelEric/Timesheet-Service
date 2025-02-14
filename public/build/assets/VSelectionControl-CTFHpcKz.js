import{B as h,ap as w,aF as H,a9 as U,ar as K,av as Y,D as E,E as L,L as R,K as o,a4 as z,aY as J,aA as Q,ac as u,M as _,b as v,aL as W,ae as G,r as X,N as Z,P as T,x as p,aU as ee,F as le,V as ae,bP as te,$ as ne,aO as oe,b9 as I,bf as ue,bi as ie,bd as re,aE as ce}from"./main-BKvLdBrx.js";const M=Symbol.for("vuetify:selection-control-group"),N=h({color:String,disabled:{type:Boolean,default:null},defaultsTarget:String,error:Boolean,id:String,inline:Boolean,falseIcon:w,trueIcon:w,ripple:{type:[Boolean,Object],default:!0},multiple:{type:Boolean,default:null},name:String,readonly:{type:Boolean,default:null},modelValue:null,type:String,valueComparator:{type:Function,default:H},...U(),...K(),...Y()},"SelectionControlGroup"),se=h({...N({defaultsTarget:"VSelectionControl"})},"VSelectionControlGroup");E()({name:"VSelectionControlGroup",props:se(),emits:{"update:modelValue":e=>!0},setup(e,i){let{slots:f}=i;const l=L(e,"modelValue"),t=R(),b=o(()=>e.id||`v-selection-control-group-${t}`),c=o(()=>e.name||b.value),a=new Set;return z(M,{modelValue:l,forceUpdate:()=>{a.forEach(n=>n())},onForceUpdate:n=>{a.add(n),J(()=>{a.delete(n)})}}),Q({[e.defaultsTarget]:{color:u(e,"color"),disabled:u(e,"disabled"),density:u(e,"density"),error:u(e,"error"),inline:u(e,"inline"),modelValue:l,multiple:o(()=>!!e.multiple||e.multiple==null&&Array.isArray(l.value)),name:c,falseIcon:u(e,"falseIcon"),trueIcon:u(e,"trueIcon"),readonly:u(e,"readonly"),ripple:u(e,"ripple"),type:u(e,"type"),valueComparator:u(e,"valueComparator")}}),_(()=>{var n;return v("div",{class:["v-selection-control-group",{"v-selection-control-group--inline":e.inline},e.class],style:e.style,role:e.type==="radio"?"radiogroup":void 0},[(n=f.default)==null?void 0:n.call(f)])}),{}}});const de=h({label:String,baseColor:String,trueValue:null,falseValue:null,value:null,...U(),...N()},"VSelectionControl");function ve(e){const i=ne(M,void 0),{densityClasses:f}=oe(e),l=L(e,"modelValue"),t=o(()=>e.trueValue!==void 0?e.trueValue:e.value!==void 0?e.value:!0),b=o(()=>e.falseValue!==void 0?e.falseValue:!1),c=o(()=>!!e.multiple||e.multiple==null&&Array.isArray(l.value)),a=o({get(){const m=i?i.modelValue.value:l.value;return c.value?I(m).some(r=>e.valueComparator(r,t.value)):e.valueComparator(m,t.value)},set(m){if(e.readonly)return;const r=m?t.value:b.value;let y=r;c.value&&(y=m?[...I(l.value),r]:I(l.value).filter(s=>!e.valueComparator(s,t.value))),i?i.modelValue.value=y:l.value=y}}),{textColorClasses:n,textColorStyles:C}=ue(o(()=>{if(!(e.error||e.disabled))return a.value?e.color:e.baseColor})),{backgroundColorClasses:V,backgroundColorStyles:g}=ie(o(()=>a.value&&!e.error&&!e.disabled?e.color:e.baseColor)),k=o(()=>a.value?e.trueIcon:e.falseIcon);return{group:i,densityClasses:f,trueValue:t,falseValue:b,model:a,textColorClasses:n,textColorStyles:C,backgroundColorClasses:V,backgroundColorStyles:g,icon:k}}const me=E()({name:"VSelectionControl",directives:{Ripple:W},inheritAttrs:!1,props:de(),emits:{"update:modelValue":e=>!0},setup(e,i){let{attrs:f,slots:l}=i;const{group:t,densityClasses:b,icon:c,model:a,textColorClasses:n,textColorStyles:C,backgroundColorClasses:V,backgroundColorStyles:g,trueValue:k}=ve(e),m=R(),r=G(!1),y=G(!1),s=X(),S=o(()=>e.id||`input-${m}`),F=o(()=>!e.disabled&&!e.readonly);t==null||t.onForceUpdate(()=>{s.value&&(s.value.checked=a.value)});function P(d){F.value&&(r.value=!0,re(d.target,":focus-visible")!==!1&&(y.value=!0))}function x(){r.value=!1,y.value=!1}function $(d){d.stopPropagation()}function j(d){if(!F.value){s.value&&(s.value.checked=a.value);return}e.readonly&&t&&ce(()=>t.forceUpdate()),a.value=d.target.checked}return _(()=>{var B,D;const d=l.label?l.label({label:e.label,props:{for:S.value}}):e.label,[O,q]=Z(f),A=v("input",T({ref:s,checked:a.value,disabled:!!e.disabled,id:S.value,onBlur:x,onFocus:P,onInput:j,"aria-disabled":!!e.disabled,"aria-label":e.label,type:e.type,value:k.value,name:e.name,"aria-checked":e.type==="checkbox"?a.value:void 0},q),null);return v("div",T({class:["v-selection-control",{"v-selection-control--dirty":a.value,"v-selection-control--disabled":e.disabled,"v-selection-control--error":e.error,"v-selection-control--focused":r.value,"v-selection-control--focus-visible":y.value,"v-selection-control--inline":e.inline},b.value,e.class]},O,{style:e.style}),[v("div",{class:["v-selection-control__wrapper",n.value],style:C.value},[(B=l.default)==null?void 0:B.call(l,{backgroundColorClasses:V,backgroundColorStyles:g}),p(v("div",{class:["v-selection-control__input"]},[((D=l.input)==null?void 0:D.call(l,{model:a,textColorClasses:n,textColorStyles:C,backgroundColorClasses:V,backgroundColorStyles:g,inputNode:A,icon:c.value,props:{onFocus:P,onBlur:x,id:S.value}}))??v(le,null,[c.value&&v(ae,{key:"icon",icon:c.value},null),A])]),[[ee("ripple"),e.ripple&&[!e.disabled&&!e.readonly,null,["center","circle"]]]])]),d&&v(te,{for:S.value,onClick:$},{default:()=>[d]})])}),{isFocused:r,input:s}}});export{me as V,de as m};
