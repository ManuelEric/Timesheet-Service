import{m as V,V as a}from"./VSelectionControl-D_i6kd7L.js";import{B as f,ap as v,D as I,E as c,K as l,M as b,b5 as k,b as x,P as h}from"./main-DiavuC11.js";const C=f({indeterminate:Boolean,indeterminateIcon:{type:v,default:"$checkboxIndeterminate"},...V({falseIcon:"$checkboxOff",trueIcon:"$checkboxOn"})},"VCheckboxBtn"),p=I()({name:"VCheckboxBtn",props:C(),emits:{"update:modelValue":e=>!0,"update:indeterminate":e=>!0},setup(e,r){let{slots:s}=r;const t=c(e,"indeterminate"),n=c(e,"modelValue");function u(o){t.value&&(t.value=!1)}const i=l(()=>t.value?e.indeterminateIcon:e.falseIcon),m=l(()=>t.value?e.indeterminateIcon:e.trueIcon);return b(()=>{const o=k(a.filterProps(e),["modelValue"]);return x(a,h(o,{modelValue:n.value,"onUpdate:modelValue":[d=>n.value=d,u],class:["v-checkbox-btn",e.class],style:e.style,type:"checkbox",falseIcon:i.value,trueIcon:m.value,"aria-checked":t.value?"mixed":void 0}),s)}),{}}});export{p as V,C as m};
