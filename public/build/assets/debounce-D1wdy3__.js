import{bB as v,g as B}from"./main-hx09Hrpa.js";function F(e){var t=typeof e;return e!=null&&(t=="object"||t=="function")}var L=F,M=typeof v=="object"&&v&&v.Object===Object&&v,D=M,U=D,H=typeof self=="object"&&self&&self.Object===Object&&self,X=U||H||Function("return this")(),N=X,q=N,z=function(){return q.Date.now()},J=z,K=/\s/;function Q(e){for(var t=e.length;t--&&K.test(e.charAt(t)););return t}var V=Q,Y=V,Z=/^\s+/;function ee(e){return e&&e.slice(0,Y(e)+1).replace(Z,"")}var te=ee,re=N,ne=re.Symbol,w=ne,_=w,R=Object.prototype,ie=R.hasOwnProperty,ae=R.toString,l=_?_.toStringTag:void 0;function oe(e){var t=ie.call(e,l),i=e[l];try{e[l]=void 0;var a=!0}catch{}var f=ae.call(e);return a&&(t?e[l]=i:delete e[l]),f}var fe=oe,ce=Object.prototype,se=ce.toString;function ue(e){return se.call(e)}var be=ue,h=w,de=fe,me=be,le="[object Null]",ge="[object Undefined]",I=h?h.toStringTag:void 0;function ve(e){return e==null?e===void 0?ge:le:I&&I in Object(e)?de(e):me(e)}var Te=ve;function ye(e){return e!=null&&typeof e=="object"}var je=ye,Se=Te,$e=je,Oe="[object Symbol]";function pe(e){return typeof e=="symbol"||$e(e)&&Se(e)==Oe}var xe=pe,_e=te,E=L,he=xe,k=NaN,Ie=/^[-+]0x[0-9a-f]+$/i,Ee=/^0b[01]+$/i,ke=/^0o[0-7]+$/i,Ge=parseInt;function Le(e){if(typeof e=="number")return e;if(he(e))return k;if(E(e)){var t=typeof e.valueOf=="function"?e.valueOf():e;e=E(t)?t+"":t}if(typeof e!="string")return e===0?e:+e;e=_e(e);var i=Ee.test(e);return i||ke.test(e)?Ge(e.slice(2),i?2:8):Ie.test(e)?k:+e}var Ne=Le,we=L,S=J,G=Ne,Re="Expected a function",We=Math.max,Ce=Math.min;function Pe(e,t,i){var a,f,u,s,n,c,b=0,$=!1,d=!1,T=!0;if(typeof e!="function")throw new TypeError(Re);t=G(t)||0,we(i)&&($=!!i.leading,d="maxWait"in i,u=d?We(G(i.maxWait)||0,t):u,T="trailing"in i?!!i.trailing:T);function y(r){var o=a,m=f;return a=f=void 0,b=r,s=e.apply(m,o),s}function W(r){return b=r,n=setTimeout(g,t),$?y(r):s}function C(r){var o=r-c,m=r-b,x=t-o;return d?Ce(x,u-m):x}function O(r){var o=r-c,m=r-b;return c===void 0||o>=t||o<0||d&&m>=u}function g(){var r=S();if(O(r))return p(r);n=setTimeout(g,C(r))}function p(r){return n=void 0,T&&a?y(r):(a=f=void 0,s)}function P(){n!==void 0&&clearTimeout(n),b=0,a=c=f=n=void 0}function A(){return n===void 0?s:p(S())}function j(){var r=S(),o=O(r);if(a=arguments,f=this,c=r,o){if(n===void 0)return W(c);if(d)return clearTimeout(n),n=setTimeout(g,t),y(c)}return n===void 0&&(n=setTimeout(g,t)),s}return j.cancel=P,j.flush=A,j}var Ae=Pe;const Fe=B(Ae);export{Fe as d};
