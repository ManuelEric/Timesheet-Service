import{B as ue,aW as ol,a0 as Ae,aX as il,a7 as Ke,a8 as Ee,a9 as He,D as fe,aa as Ue,aY as sl,aR as cl,aj as me,M as he,b as a,P as $,$ as ke,aZ as Be,aO as rl,a1 as dl,a3 as vl,a_ as fl,a6 as ml,a$ as hl,aP as gl,b0 as yl,ak as _e,b1 as pl,ab as bl,ac as kl,ae as Vl,ah as Sl,b2 as Cl,E as ve,b3 as wl,b4 as Pl,K as T,x as Le,b5 as Il,al as xl,b6 as Al,V as oe,Q as de,aI as Fl,F as le,aS as ze,an as ee,aB as Tl,az as Q,b7 as De,r as J,b8 as Ne,b9 as Fe,ba as Dl,aV as Ve,I as Se,a2 as _l,bb as Rl,ad as Ml,bc as Bl,e as Ll,bd as Ol,be as pe,bf as je,bg as $e,aJ as Ge,bh as Kl,bi as Ce,bj as qe,W as we,i as We,bk as Xe,j as Qe,bl as Ye,bm as Pe,u as be,bn as El,ai as Hl,bo as Ul}from"./main-BW436c6G.js";import{m as zl,u as Je,V as Ze,a as Ie}from"./VList-BTCg86iW.js";import{V as el}from"./VCheckboxBtn-CHObhekr.js";import{V as xe}from"./VAvatar-DNY9pCcK.js";import{m as Nl,V as Oe}from"./VSlideGroup-DqpIEY5r.js";const ll=Symbol.for("vuetify:v-chip-group"),jl=ue({column:Boolean,filter:Boolean,valueComparator:{type:Function,default:ol},...Nl(),...Ae(),...il({selectedClass:"v-chip--selected"}),...Ke(),...Ee(),...He({variant:"tonal"})},"VChipGroup");fe()({name:"VChipGroup",props:jl(),emits:{"update:modelValue":e=>!0},setup(e,r){let{slots:l}=r;const{themeClasses:f}=Ue(e),{isSelected:t,select:v,next:y,prev:d,selected:o}=sl(e,ll);return cl({VChip:{color:me(e,"color"),disabled:me(e,"disabled"),filter:me(e,"filter"),variant:me(e,"variant")}}),he(()=>{const k=Oe.filterProps(e);return a(Oe,$(k,{class:["v-chip-group",{"v-chip-group--column":e.column},f.value,e.class],style:e.style}),{default:()=>{var x;return[(x=l.default)==null?void 0:x.call(l,{isSelected:t,select:v,next:y,prev:d,selected:o.value})]}})}),{}}});const $l=ue({activeClass:String,appendAvatar:String,appendIcon:ke,closable:Boolean,closeIcon:{type:ke,default:"$delete"},closeLabel:{type:String,default:"$vuetify.close"},draggable:Boolean,filter:Boolean,filterIcon:{type:String,default:"$complete"},label:Boolean,link:{type:Boolean,default:void 0},pill:Boolean,prependAvatar:String,prependIcon:ke,ripple:{type:[Boolean,Object],default:!0},text:String,modelValue:{type:Boolean,default:!0},onClick:Be(),onClickOnce:Be(),...rl(),...Ae(),...dl(),...vl(),...fl(),...ml(),...hl(),...gl(),...Ke({tag:"span"}),...Ee(),...He({variant:"tonal"})},"VChip"),tl=fe()({name:"VChip",directives:{Ripple:yl},props:$l(),emits:{"click:close":e=>!0,"update:modelValue":e=>!0,"group:selected":e=>!0,click:e=>!0},setup(e,r){let{attrs:l,emit:f,slots:t}=r;const{t:v}=_e(),{borderClasses:y}=pl(e),{colorClasses:d,colorStyles:o,variantClasses:k}=bl(e),{densityClasses:x}=kl(e),{elevationClasses:h}=Vl(e),{roundedClasses:i}=Sl(e),{sizeClasses:C}=Cl(e),{themeClasses:I}=Ue(e),A=ve(e,"modelValue"),s=wl(e,ll,!1),w=Pl(e,l),K=T(()=>e.link!==!1&&w.isLink.value),H=T(()=>!e.disabled&&e.link!==!1&&(!!s||e.link||w.isClickable.value)),V=T(()=>({"aria-label":v(e.closeLabel),onClick(p){p.preventDefault(),p.stopPropagation(),A.value=!1,f("click:close",p)}}));function g(p){var G;f("click",p),H.value&&((G=w.navigate)==null||G.call(w,p),s==null||s.toggle())}function ie(p){(p.key==="Enter"||p.key===" ")&&(p.preventDefault(),g(p))}return()=>{const p=w.isLink.value?"a":e.tag,G=!!(e.appendIcon||e.appendAvatar),te=!!(G||t.append),O=!!(t.close||e.closable),q=!!(t.filter||e.filter)&&s,Y=!!(e.prependIcon||e.prependAvatar),ae=!!(Y||t.prepend),Z=!s||s.isSelected.value;return A.value&&Le(a(p,{class:["v-chip",{"v-chip--disabled":e.disabled,"v-chip--label":e.label,"v-chip--link":H.value,"v-chip--filter":q,"v-chip--pill":e.pill},I.value,y.value,Z?d.value:void 0,x.value,h.value,i.value,C.value,k.value,s==null?void 0:s.selectedClass.value,e.class],style:[Z?o.value:void 0,e.style],disabled:e.disabled||void 0,draggable:e.draggable,href:w.href.value,tabindex:H.value?0:void 0,onClick:g,onKeydown:H.value&&!K.value&&ie},{default:()=>{var j;return[xl(H.value,"v-chip"),q&&a(Al,{key:"filter"},{default:()=>[Le(a("div",{class:"v-chip__filter"},[t.filter?a(de,{key:"filter-defaults",disabled:!e.filterIcon,defaults:{VIcon:{icon:e.filterIcon}}},t.filter):a(oe,{key:"filter-icon",icon:e.filterIcon},null)]),[[Fl,s.isSelected.value]])]}),ae&&a("div",{key:"prepend",class:"v-chip__prepend"},[t.prepend?a(de,{key:"prepend-defaults",disabled:!Y,defaults:{VAvatar:{image:e.prependAvatar,start:!0},VIcon:{icon:e.prependIcon,start:!0}}},t.prepend):a(le,null,[e.prependIcon&&a(oe,{key:"prepend-icon",icon:e.prependIcon,start:!0},null),e.prependAvatar&&a(xe,{key:"prepend-avatar",image:e.prependAvatar,start:!0},null)])]),a("div",{class:"v-chip__content","data-no-activator":""},[((j=t.default)==null?void 0:j.call(t,{isSelected:s==null?void 0:s.isSelected.value,selectedClass:s==null?void 0:s.selectedClass.value,select:s==null?void 0:s.select,toggle:s==null?void 0:s.toggle,value:s==null?void 0:s.value.value,disabled:e.disabled}))??e.text]),te&&a("div",{key:"append",class:"v-chip__append"},[t.append?a(de,{key:"append-defaults",disabled:!G,defaults:{VAvatar:{end:!0,image:e.appendAvatar},VIcon:{end:!0,icon:e.appendIcon}}},t.append):a(le,null,[e.appendIcon&&a(oe,{key:"append-icon",end:!0,icon:e.appendIcon},null),e.appendAvatar&&a(xe,{key:"append-avatar",end:!0,image:e.appendAvatar},null)])]),O&&a("button",$({key:"close",class:"v-chip__close",type:"button"},V.value),[t.close?a(de,{key:"close-defaults",defaults:{VIcon:{icon:e.closeIcon,size:"x-small"}}},t.close):a(oe,{key:"close-icon",icon:e.closeIcon,size:"x-small"},null)])]}}),[[Il("ripple"),H.value&&e.ripple,null]])}}}),Gl=ue({renderless:Boolean,...Ae()},"VVirtualScrollItem"),ql=fe()({name:"VVirtualScrollItem",inheritAttrs:!1,props:Gl(),emits:{"update:height":e=>!0},setup(e,r){let{attrs:l,emit:f,slots:t}=r;const{resizeRef:v,contentRect:y}=ze(void 0,"border");ee(()=>{var d;return(d=y.value)==null?void 0:d.height},d=>{d!=null&&f("update:height",d)}),he(()=>{var d,o;return e.renderless?a(le,null,[(d=t.default)==null?void 0:d.call(t,{itemRef:v})]):a("div",$({ref:v,class:["v-virtual-scroll__item",e.class],style:e.style},l),[(o=t.default)==null?void 0:o.call(t)])})}}),Wl=-1,Xl=1,Te=100,Ql=ue({itemHeight:{type:[Number,String],default:null},height:[Number,String]},"virtual");function Yl(e,r){const l=Tl(),f=Q(0);De(()=>{f.value=parseFloat(e.itemHeight||0)});const t=Q(0),v=Q(Math.ceil((parseInt(e.height)||l.height.value)/(f.value||16))||1),y=Q(0),d=Q(0),o=J(),k=J();let x=0;const{resizeRef:h,contentRect:i}=ze();De(()=>{h.value=o.value});const C=T(()=>{var u;return o.value===document.documentElement?l.height.value:((u=i.value)==null?void 0:u.height)||parseInt(e.height)||0}),I=T(()=>!!(o.value&&k.value&&C.value&&f.value));let A=Array.from({length:r.value.length}),s=Array.from({length:r.value.length});const w=Q(0);let K=-1;function H(u){return A[u]||f.value}const V=Dl(()=>{const u=performance.now();s[0]=0;const m=r.value.length;for(let B=1;B<=m-1;B++)s[B]=(s[B-1]||0)+H(B-1);w.value=Math.max(w.value,performance.now()-u)},w),g=ee(I,u=>{u&&(g(),x=k.value.offsetTop,V.immediate(),j(),~K&&Ve(()=>{Se&&window.requestAnimationFrame(()=>{re(K),K=-1})}))});Ne(()=>{V.clear()});function ie(u,m){const B=A[u],D=f.value;f.value=D?Math.min(f.value,m):m,(B!==m||D!==f.value)&&(A[u]=m,V())}function p(u){return u=Fe(u,0,r.value.length-1),s[u]||0}function G(u){return Jl(s,u)}let te=0,O=0,q=0;ee(C,(u,m)=>{m&&(j(),u<m&&requestAnimationFrame(()=>{O=0,j()}))});function Y(){if(!o.value||!k.value)return;const u=o.value.scrollTop,m=performance.now();m-q>500?(O=Math.sign(u-te),x=k.value.offsetTop):O=u-te,te=u,q=m,j()}function ae(){!o.value||!k.value||(O=0,q=0,j())}let Z=-1;function j(){cancelAnimationFrame(Z),Z=requestAnimationFrame(se)}function se(){if(!o.value||!C.value)return;const u=te-x,m=Math.sign(O),B=Math.max(0,u-Te),D=Fe(G(B),0,r.value.length),P=u+C.value+Te,L=Fe(G(P)+1,D+1,r.value.length);if((m!==Wl||D<t.value)&&(m!==Xl||L>v.value)){const F=p(t.value)-p(D),U=p(L)-p(v.value);Math.max(F,U)>Te?(t.value=D,v.value=L):(D<=0&&(t.value=D),L>=r.value.length&&(v.value=L))}y.value=p(t.value),d.value=p(r.value.length)-p(v.value)}function re(u){const m=p(u);!o.value||u&&!m?K=u:o.value.scrollTop=m}const c=T(()=>r.value.slice(t.value,v.value).map((u,m)=>({raw:u,index:m+t.value})));return ee(r,()=>{A=Array.from({length:r.value.length}),s=Array.from({length:r.value.length}),V.immediate(),j()},{deep:!0}),{containerRef:o,markerRef:k,computedItems:c,paddingTop:y,paddingBottom:d,scrollToIndex:re,handleScroll:Y,handleScrollend:ae,handleItemResize:ie}}function Jl(e,r){let l=e.length-1,f=0,t=0,v=null,y=-1;if(e[l]<r)return l;for(;f<=l;)if(t=f+l>>1,v=e[t],v>r)l=t-1;else if(v<r)y=t,f=t+1;else return v===r?t:f;return y}const Zl=ue({items:{type:Array,default:()=>[]},renderless:Boolean,...Ql(),...Ae(),..._l()},"VVirtualScroll"),al=fe()({name:"VVirtualScroll",props:Zl(),setup(e,r){let{slots:l}=r;const f=Rl("VVirtualScroll"),{dimensionStyles:t}=Ml(e),{containerRef:v,markerRef:y,handleScroll:d,handleScrollend:o,handleItemResize:k,scrollToIndex:x,paddingTop:h,paddingBottom:i,computedItems:C}=Yl(e,me(e,"items"));return Bl(()=>e.renderless,()=>{function I(){var w,K;const s=(arguments.length>0&&arguments[0]!==void 0?arguments[0]:!1)?"addEventListener":"removeEventListener";v.value===document.documentElement?(document[s]("scroll",d,{passive:!0}),document[s]("scrollend",o)):((w=v.value)==null||w[s]("scroll",d,{passive:!0}),(K=v.value)==null||K[s]("scrollend",o))}Ll(()=>{v.value=Ol(f.vnode.el,!0),I(!0)}),Ne(I)}),he(()=>{const I=C.value.map(A=>a(ql,{key:A.index,renderless:e.renderless,"onUpdate:height":s=>k(A.index,s)},{default:s=>{var w;return(w=l.default)==null?void 0:w.call(l,{item:A.raw,index:A.index,...s})}}));return e.renderless?a(le,null,[a("div",{ref:y,class:"v-virtual-scroll__spacer",style:{paddingTop:pe(h.value)}},null),I,a("div",{class:"v-virtual-scroll__spacer",style:{paddingBottom:pe(i.value)}},null)]):a("div",{ref:v,class:["v-virtual-scroll",e.class],onScrollPassive:d,onScrollend:o,style:[t.value,e.style]},[a("div",{ref:y,class:"v-virtual-scroll__container",style:{paddingTop:pe(h.value),paddingBottom:pe(i.value)}},[I])])}),{scrollToIndex:x}}});function nl(e,r){const l=Q(!1);let f;function t(d){cancelAnimationFrame(f),l.value=!0,f=requestAnimationFrame(()=>{f=requestAnimationFrame(()=>{l.value=!1})})}async function v(){await new Promise(d=>requestAnimationFrame(d)),await new Promise(d=>requestAnimationFrame(d)),await new Promise(d=>requestAnimationFrame(d)),await new Promise(d=>{if(l.value){const o=ee(l,()=>{o(),d()})}else d()})}async function y(d){var x,h;if(d.key==="Tab"&&((x=r.value)==null||x.focus()),!["PageDown","PageUp","Home","End"].includes(d.key))return;const o=(h=e.value)==null?void 0:h.$el;if(!o)return;(d.key==="Home"||d.key==="End")&&o.scrollTo({top:d.key==="Home"?0:o.scrollHeight,behavior:"smooth"}),await v();const k=o.querySelectorAll(":scope > :not(.v-virtual-scroll__spacer)");if(d.key==="PageDown"||d.key==="Home"){const i=o.getBoundingClientRect().top;for(const C of k)if(C.getBoundingClientRect().top>=i){C.focus();break}}else{const i=o.getBoundingClientRect().bottom;for(const C of[...k].reverse())if(C.getBoundingClientRect().bottom<=i){C.focus();break}}}return{onListScroll:t,onListKeydown:y}}const ul=ue({chips:Boolean,closableChips:Boolean,closeText:{type:String,default:"$vuetify.close"},openText:{type:String,default:"$vuetify.open"},eager:Boolean,hideNoData:Boolean,hideSelected:Boolean,listProps:{type:Object},menu:Boolean,menuIcon:{type:ke,default:"$dropdown"},menuProps:{type:Object},multiple:Boolean,noDataText:{type:String,default:"$vuetify.noDataText"},openOnClear:Boolean,itemColor:String,...zl({itemChildren:!1})},"Select"),et=ue({...ul(),...je($e({modelValue:null,role:"combobox"}),["validationValue","dirty","appendInnerIcon"]),...Ge({transition:{component:Kl}})},"VSelect");fe()({name:"VSelect",props:et(),emits:{"update:focused":e=>!0,"update:modelValue":e=>!0,"update:menu":e=>!0},setup(e,r){let{slots:l}=r;const{t:f}=_e(),t=J(),v=J(),y=J(),d=ve(e,"menu"),o=T({get:()=>d.value,set:c=>{var u;d.value&&!c&&((u=v.value)!=null&&u.ΨopenChildren)||(d.value=c)}}),{items:k,transformIn:x,transformOut:h}=Je(e),i=ve(e,"modelValue",[],c=>x(c===null?[null]:Ce(c)),c=>{const u=h(c);return e.multiple?u:u[0]??null}),C=T(()=>typeof e.counterValue=="function"?e.counterValue(i.value):typeof e.counterValue=="number"?e.counterValue:i.value.length),I=qe(),A=T(()=>i.value.map(c=>c.value)),s=Q(!1),w=T(()=>o.value?e.closeText:e.openText);let K="",H;const V=T(()=>e.hideSelected?k.value.filter(c=>!i.value.some(u=>e.valueComparator(u,c))):k.value),g=T(()=>e.hideNoData&&!V.value.length||e.readonly||(I==null?void 0:I.isReadonly.value)),ie=T(()=>{var c;return{...e.menuProps,activatorProps:{...((c=e.menuProps)==null?void 0:c.activatorProps)||{},"aria-haspopup":"listbox"}}}),p=J(),{onListScroll:G,onListKeydown:te}=nl(p,t);function O(c){e.openOnClear&&(o.value=!0)}function q(){g.value||(o.value=!o.value)}function Y(c){var P,L;if(!c.key||e.readonly||I!=null&&I.isReadonly.value)return;["Enter"," ","ArrowDown","ArrowUp","Home","End"].includes(c.key)&&c.preventDefault(),["Enter","ArrowDown"," "].includes(c.key)&&(o.value=!0),["Escape","Tab"].includes(c.key)&&(o.value=!1),c.key==="Home"?(P=p.value)==null||P.focus("first"):c.key==="End"&&((L=p.value)==null||L.focus("last"));const u=1e3;function m(F){const U=F.key.length===1,z=!F.ctrlKey&&!F.metaKey&&!F.altKey;return U&&z}if(e.multiple||!m(c))return;const B=performance.now();B-H>u&&(K=""),K+=c.key.toLowerCase(),H=B;const D=k.value.find(F=>F.title.toLowerCase().startsWith(K));if(D!==void 0){i.value=[D];const F=V.value.indexOf(D);Se&&window.requestAnimationFrame(()=>{var U;F>=0&&((U=y.value)==null||U.scrollToIndex(F))})}}function ae(c){let u=arguments.length>1&&arguments[1]!==void 0?arguments[1]:!0;if(!c.props.disabled)if(e.multiple){const m=i.value.findIndex(D=>e.valueComparator(D.value,c.value)),B=u??!~m;if(~m){const D=B?[...i.value,c]:[...i.value];D.splice(m,1),i.value=D}else B&&(i.value=[...i.value,c])}else{const m=u!==!1;i.value=m?[c]:[],Ve(()=>{o.value=!1})}}function Z(c){var u;(u=p.value)!=null&&u.$el.contains(c.relatedTarget)||(o.value=!1)}function j(){var c;s.value&&((c=t.value)==null||c.focus())}function se(c){s.value=!0}function re(c){if(c==null)i.value=[];else if(Pe(t.value,":autofill")||Pe(t.value,":-webkit-autofill")){const u=k.value.find(m=>m.title===c);u&&ae(u)}else t.value&&(t.value.value="")}return ee(o,()=>{if(!e.hideSelected&&o.value&&i.value.length){const c=V.value.findIndex(u=>i.value.some(m=>e.valueComparator(m.value,u.value)));Se&&window.requestAnimationFrame(()=>{var u;c>=0&&((u=y.value)==null||u.scrollToIndex(c))})}}),ee(()=>e.items,(c,u)=>{o.value||s.value&&!u.length&&c.length&&(o.value=!0)}),he(()=>{const c=!!(e.chips||l.chip),u=!!(!e.hideNoData||V.value.length||l["prepend-item"]||l["append-item"]||l["no-data"]),m=i.value.length>0,B=we.filterProps(e),D=m||!s.value&&e.label&&!e.persistentPlaceholder?void 0:e.placeholder;return a(we,$({ref:t},B,{modelValue:i.value.map(P=>P.props.value).join(", "),"onUpdate:modelValue":re,focused:s.value,"onUpdate:focused":P=>s.value=P,validationValue:i.externalValue,counterValue:C.value,dirty:m,class:["v-select",{"v-select--active-menu":o.value,"v-select--chips":!!e.chips,[`v-select--${e.multiple?"multiple":"single"}`]:!0,"v-select--selected":i.value.length,"v-select--selection-slot":!!l.selection},e.class],style:e.style,inputmode:"none",placeholder:D,"onClick:clear":O,"onMousedown:control":q,onBlur:Z,onKeydown:Y,"aria-label":f(w.value),title:f(w.value)}),{...l,default:()=>a(le,null,[a(We,$({ref:v,modelValue:o.value,"onUpdate:modelValue":P=>o.value=P,activator:"parent",contentClass:"v-select__content",disabled:g.value,eager:e.eager,maxHeight:310,openOnClick:!1,closeOnContentClick:!1,transition:e.transition,onAfterLeave:j},ie.value),{default:()=>[u&&a(Ze,$({ref:p,selected:A.value,selectStrategy:e.multiple?"independent":"single-independent",onMousedown:P=>P.preventDefault(),onKeydown:te,onFocusin:se,onScrollPassive:G,tabindex:"-1","aria-live":"polite",color:e.itemColor??e.color},e.listProps),{default:()=>{var P,L,F;return[(P=l["prepend-item"])==null?void 0:P.call(l),!V.value.length&&!e.hideNoData&&(((L=l["no-data"])==null?void 0:L.call(l))??a(Ie,{title:f(e.noDataText)},null)),a(al,{ref:y,renderless:!0,items:V.value},{default:U=>{var b;let{item:z,index:ne,itemRef:R}=U;const n=$(z.props,{ref:R,key:ne,onClick:()=>ae(z,null)});return((b=l.item)==null?void 0:b.call(l,{item:z,index:ne,props:n}))??a(Ie,$(n,{role:"option"}),{prepend:_=>{let{isSelected:S}=_;return a(le,null,[e.multiple&&!e.hideSelected?a(el,{key:z.value,modelValue:S,ripple:!1,tabindex:"-1"},null):void 0,z.props.prependAvatar&&a(xe,{image:z.props.prependAvatar},null),z.props.prependIcon&&a(oe,{icon:z.props.prependIcon},null)])}})}}),(F=l["append-item"])==null?void 0:F.call(l)]}})]}),i.value.map((P,L)=>{function F(R){R.stopPropagation(),R.preventDefault(),ae(P,!1)}const U={"onClick:close":F,onKeydown(R){R.key!=="Enter"&&R.key!==" "||(R.preventDefault(),R.stopPropagation(),F(R))},onMousedown(R){R.preventDefault(),R.stopPropagation()},modelValue:!0,"onUpdate:modelValue":void 0},z=c?!!l.chip:!!l.selection,ne=z?Xe(c?l.chip({item:P,index:L,props:U}):l.selection({item:P,index:L})):void 0;if(!(z&&!ne))return a("div",{key:P.value,class:"v-select__selection"},[c?l.chip?a(de,{key:"chip-defaults",defaults:{VChip:{closable:e.closableChips,size:"small",text:P.title}}},{default:()=>[ne]}):a(tl,$({key:"chip",closable:e.closableChips,size:"small",text:P.title,disabled:P.props.disabled},U),null):ne??a("span",{class:"v-select__selection-text"},[P.title,e.multiple&&L<i.value.length-1&&a("span",{class:"v-select__selection-comma"},[Qe(",")])])])})]),"append-inner":function(){var U;for(var P=arguments.length,L=new Array(P),F=0;F<P;F++)L[F]=arguments[F];return a(le,null,[(U=l["append-inner"])==null?void 0:U.call(l,...L),e.menuIcon?a(oe,{class:"v-select__menu-icon",icon:e.menuIcon},null):void 0])}})}),Ye({isFocused:s,menu:o,select:ae},t)}});const lt=(e,r,l)=>e==null||r==null?-1:e.toString().toLocaleLowerCase().indexOf(r.toString().toLocaleLowerCase()),tt=ue({customFilter:Function,customKeyFilter:Object,filterKeys:[Array,String],filterMode:{type:String,default:"intersection"},noFilter:Boolean},"filter");function at(e,r,l){var d;const f=[],t=(l==null?void 0:l.default)??lt,v=l!=null&&l.filterKeys?Ce(l.filterKeys):!1,y=Object.keys((l==null?void 0:l.customKeyFilter)??{}).length;if(!(e!=null&&e.length))return f;e:for(let o=0;o<e.length;o++){const[k,x=k]=Ce(e[o]),h={},i={};let C=-1;if((r||y>0)&&!(l!=null&&l.noFilter)){if(typeof k=="object"){const s=v||Object.keys(x);for(const w of s){const K=El(x,w),H=(d=l==null?void 0:l.customKeyFilter)==null?void 0:d[w];if(C=H?H(K,r,k):t(K,r,k),C!==-1&&C!==!1)H?h[w]=C:i[w]=C;else if((l==null?void 0:l.filterMode)==="every")continue e}}else C=t(k,r,k),C!==-1&&C!==!1&&(i.title=C);const I=Object.keys(i).length,A=Object.keys(h).length;if(!I&&!A||(l==null?void 0:l.filterMode)==="union"&&A!==y&&!I||(l==null?void 0:l.filterMode)==="intersection"&&(A!==y||!I))continue}f.push({index:o,matches:{...i,...h}})}return f}function nt(e,r,l,f){const t=J([]),v=J(new Map),y=T(()=>be(r));De(()=>{const o=typeof l=="function"?l():be(l),k=typeof o!="string"&&typeof o!="number"?"":String(o),x=at(y.value,k,{customKeyFilter:{...e.customKeyFilter,...be(f==null?void 0:f.customKeyFilter)},default:e.customFilter,filterKeys:e.filterKeys,filterMode:e.filterMode,noFilter:e.noFilter}),h=be(r),i=[],C=new Map;x.forEach(I=>{let{index:A,matches:s}=I;const w=h[A];i.push(w),C.set(w.value,s)}),t.value=i,v.value=C});function d(o){return v.value.get(o.value)}return{filteredItems:t,filteredMatches:v,getMatches:d}}function ut(e,r,l){if(r==null)return e;if(Array.isArray(r))throw new Error("Multiple matches is not implemented");return typeof r=="number"&&~r?a(le,null,[a("span",{class:"v-autocomplete__unmask"},[e.substr(0,r)]),a("span",{class:"v-autocomplete__mask"},[e.substr(r,l)]),a("span",{class:"v-autocomplete__unmask"},[e.substr(r+l)])]):e}const ot=ue({autoSelectFirst:{type:[Boolean,String]},clearOnSelect:Boolean,search:String,...tt({filterKeys:["title"]}),...ul(),...je($e({modelValue:null,role:"combobox"}),["validationValue","dirty","appendInnerIcon"]),...Ge({transition:!1})},"VAutocomplete"),vt=fe()({name:"VAutocomplete",props:ot(),emits:{"update:focused":e=>!0,"update:search":e=>!0,"update:modelValue":e=>!0,"update:menu":e=>!0},setup(e,r){let{slots:l}=r;const{t:f}=_e(),t=J(),v=Q(!1),y=Q(!0),d=Q(!1),o=J(),k=J(),x=ve(e,"menu"),h=T({get:()=>x.value,set:n=>{var b;x.value&&!n&&((b=o.value)!=null&&b.ΨopenChildren)||(x.value=n)}}),i=Q(-1),C=T(()=>{var n;return(n=t.value)==null?void 0:n.color}),I=T(()=>h.value?e.closeText:e.openText),{items:A,transformIn:s,transformOut:w}=Je(e),{textColorClasses:K,textColorStyles:H}=Hl(C),V=ve(e,"search",""),g=ve(e,"modelValue",[],n=>s(n===null?[null]:Ce(n)),n=>{const b=w(n);return e.multiple?b:b[0]??null}),ie=T(()=>typeof e.counterValue=="function"?e.counterValue(g.value):typeof e.counterValue=="number"?e.counterValue:g.value.length),p=qe(),{filteredItems:G,getMatches:te}=nt(e,A,()=>y.value?"":V.value),O=T(()=>e.hideSelected?G.value.filter(n=>!g.value.some(b=>b.value===n.value)):G.value),q=T(()=>!!(e.chips||l.chip)),Y=T(()=>q.value||!!l.selection),ae=T(()=>g.value.map(n=>n.props.value)),Z=T(()=>{var b;return(e.autoSelectFirst===!0||e.autoSelectFirst==="exact"&&V.value===((b=O.value[0])==null?void 0:b.title))&&O.value.length>0&&!y.value&&!d.value}),j=T(()=>e.hideNoData&&!O.value.length||e.readonly||(p==null?void 0:p.isReadonly.value)),se=J(),{onListScroll:re,onListKeydown:c}=nl(se,t);function u(n){e.openOnClear&&(h.value=!0),V.value=""}function m(){j.value||(h.value=!0)}function B(n){j.value||(v.value&&(n.preventDefault(),n.stopPropagation()),h.value=!h.value)}function D(n){var S,M,W;if(e.readonly||p!=null&&p.isReadonly.value)return;const b=t.value.selectionStart,_=g.value.length;if((i.value>-1||["Enter","ArrowDown","ArrowUp"].includes(n.key))&&n.preventDefault(),["Enter","ArrowDown"].includes(n.key)&&(h.value=!0),["Escape"].includes(n.key)&&(h.value=!1),Z.value&&["Enter","Tab"].includes(n.key)&&!g.value.some(E=>{let{value:N}=E;return N===O.value[0].value})&&R(O.value[0]),n.key==="ArrowDown"&&Z.value&&((S=se.value)==null||S.focus("next")),["Backspace","Delete"].includes(n.key)){if(!e.multiple&&Y.value&&g.value.length>0&&!V.value)return R(g.value[0],!1);if(~i.value){const E=i.value;R(g.value[i.value],!1),i.value=E>=_-1?_-2:E}else n.key==="Backspace"&&!V.value&&(i.value=_-1)}if(e.multiple){if(n.key==="ArrowLeft"){if(i.value<0&&b>0)return;const E=i.value>-1?i.value-1:_-1;g.value[E]?i.value=E:(i.value=-1,t.value.setSelectionRange((M=V.value)==null?void 0:M.length,(W=V.value)==null?void 0:W.length))}if(n.key==="ArrowRight"){if(i.value<0)return;const E=i.value+1;g.value[E]?i.value=E:(i.value=-1,t.value.setSelectionRange(0,0))}}}function P(n){if(Pe(t.value,":autofill")||Pe(t.value,":-webkit-autofill")){const b=A.value.find(_=>_.title===n.target.value);b&&R(b)}}function L(){var n;v.value&&(y.value=!0,(n=t.value)==null||n.focus())}function F(n){v.value=!0,setTimeout(()=>{d.value=!0})}function U(n){d.value=!1}function z(n){(n==null||n===""&&!e.multiple&&!Y.value)&&(g.value=[])}const ne=Q(!1);function R(n){let b=arguments.length>1&&arguments[1]!==void 0?arguments[1]:!0;if(!(!n||n.props.disabled))if(e.multiple){const _=g.value.findIndex(M=>e.valueComparator(M.value,n.value)),S=b??!~_;if(~_){const M=S?[...g.value,n]:[...g.value];M.splice(_,1),g.value=M}else S&&(g.value=[...g.value,n]);e.clearOnSelect&&(V.value="")}else{const _=b!==!1;g.value=_?[n]:[],V.value=_&&!Y.value?n.title:"",Ve(()=>{h.value=!1,y.value=!0})}}return ee(v,(n,b)=>{var _;n!==b&&(n?(ne.value=!0,V.value=e.multiple||Y.value?"":String(((_=g.value.at(-1))==null?void 0:_.props.title)??""),y.value=!0,Ve(()=>ne.value=!1)):(!e.multiple&&V.value==null&&(g.value=[]),h.value=!1,g.value.some(S=>{let{title:M}=S;return M===V.value})||(V.value=""),i.value=-1))}),ee(V,n=>{!v.value||ne.value||(n&&(h.value=!0),y.value=!n)}),ee(h,()=>{if(!e.hideSelected&&h.value&&g.value.length){const n=O.value.findIndex(b=>g.value.some(_=>b.value===_.value));Se&&window.requestAnimationFrame(()=>{var b;n>=0&&((b=k.value)==null||b.scrollToIndex(n))})}}),ee(()=>e.items,(n,b)=>{h.value||v.value&&!b.length&&n.length&&(h.value=!0)}),he(()=>{const n=!!(!e.hideNoData||O.value.length||l["prepend-item"]||l["append-item"]||l["no-data"]),b=g.value.length>0,_=we.filterProps(e);return a(we,$({ref:t},_,{modelValue:V.value,"onUpdate:modelValue":[S=>V.value=S,z],focused:v.value,"onUpdate:focused":S=>v.value=S,validationValue:g.externalValue,counterValue:ie.value,dirty:b,onChange:P,class:["v-autocomplete",`v-autocomplete--${e.multiple?"multiple":"single"}`,{"v-autocomplete--active-menu":h.value,"v-autocomplete--chips":!!e.chips,"v-autocomplete--selection-slot":!!Y.value,"v-autocomplete--selecting-index":i.value>-1},e.class],style:e.style,readonly:e.readonly,placeholder:b?void 0:e.placeholder,"onClick:clear":u,"onMousedown:control":m,onKeydown:D}),{...l,default:()=>a(le,null,[a(We,$({ref:o,modelValue:h.value,"onUpdate:modelValue":S=>h.value=S,activator:"parent",contentClass:"v-autocomplete__content",disabled:j.value,eager:e.eager,maxHeight:310,openOnClick:!1,closeOnContentClick:!1,transition:e.transition,onAfterLeave:L},e.menuProps),{default:()=>[n&&a(Ze,$({ref:se,selected:ae.value,selectStrategy:e.multiple?"independent":"single-independent",onMousedown:S=>S.preventDefault(),onKeydown:c,onFocusin:F,onFocusout:U,onScrollPassive:re,tabindex:"-1","aria-live":"polite",color:e.itemColor??e.color},e.listProps),{default:()=>{var S,M,W;return[(S=l["prepend-item"])==null?void 0:S.call(l),!O.value.length&&!e.hideNoData&&(((M=l["no-data"])==null?void 0:M.call(l))??a(Ie,{title:f(e.noDataText)},null)),a(al,{ref:k,renderless:!0,items:O.value},{default:E=>{var Me;let{item:N,index:ce,itemRef:X}=E;const Re=$(N.props,{ref:X,key:ce,active:Z.value&&ce===0?!0:void 0,onClick:()=>R(N,null)});return((Me=l.item)==null?void 0:Me.call(l,{item:N,index:ce,props:Re}))??a(Ie,$(Re,{role:"option"}),{prepend:ge=>{let{isSelected:ye}=ge;return a(le,null,[e.multiple&&!e.hideSelected?a(el,{key:N.value,modelValue:ye,ripple:!1,tabindex:"-1"},null):void 0,N.props.prependAvatar&&a(xe,{image:N.props.prependAvatar},null),N.props.prependIcon&&a(oe,{icon:N.props.prependIcon},null)])},title:()=>{var ge,ye;return y.value?N.title:ut(N.title,(ge=te(N))==null?void 0:ge.title,((ye=V.value)==null?void 0:ye.length)??0)}})}}),(W=l["append-item"])==null?void 0:W.call(l)]}})]}),g.value.map((S,M)=>{function W(X){X.stopPropagation(),X.preventDefault(),R(S,!1)}const E={"onClick:close":W,onKeydown(X){X.key!=="Enter"&&X.key!==" "||(X.preventDefault(),X.stopPropagation(),W(X))},onMousedown(X){X.preventDefault(),X.stopPropagation()},modelValue:!0,"onUpdate:modelValue":void 0},N=q.value?!!l.chip:!!l.selection,ce=N?Xe(q.value?l.chip({item:S,index:M,props:E}):l.selection({item:S,index:M})):void 0;if(!(N&&!ce))return a("div",{key:S.value,class:["v-autocomplete__selection",M===i.value&&["v-autocomplete__selection--selected",K.value]],style:M===i.value?H.value:{}},[q.value?l.chip?a(de,{key:"chip-defaults",defaults:{VChip:{closable:e.closableChips,size:"small",text:S.title}}},{default:()=>[ce]}):a(tl,$({key:"chip",closable:e.closableChips,size:"small",text:S.title,disabled:S.props.disabled},E),null):ce??a("span",{class:"v-autocomplete__selection-text"},[S.title,e.multiple&&M<g.value.length-1&&a("span",{class:"v-autocomplete__selection-comma"},[Qe(",")])])])})]),"append-inner":function(){var E;for(var S=arguments.length,M=new Array(S),W=0;W<S;W++)M[W]=arguments[W];return a(le,null,[(E=l["append-inner"])==null?void 0:E.call(l,...M),e.menuIcon?a(oe,{class:"v-autocomplete__menu-icon",icon:e.menuIcon,onMousedown:B,onClick:Ul,"aria-label":f(I.value),title:f(I.value),tabindex:"-1"},null):void 0])}})}),Ye({isFocused:v,isPristine:y,menu:h,search:V,filteredItems:G,select:R},t)}});export{vt as V,tl as a};
