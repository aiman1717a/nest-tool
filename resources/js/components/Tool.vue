<template>
  <div>
      <div class="flex items-center mb-3">
          <h1 class="flex-no-shrink text-90 font-normal text-2xl">Nestable Topics</h1>
      </div>
      <vue-nestable v-model="nestableItems" @change="change()">
          <vue-nestable-handle
              slot-scope="{ item }"
              :item="item"
              class="handle flex flex-wrap">

              <div class="w-2/3">
                  <span class="font-semibold">
                      {{ item[displayName]  }}
                  </span>
                  <span class="font-lighter text-80 ml-4 text-sm">{{ item.slug }}</span>
              </div>
          </vue-nestable-handle>
      </vue-nestable>
  </div>
</template>

<script>
import _ from 'lodash';
import { VueNestable, VueNestableHandle } from 'vue-nestable'
export default {
    components: {
        VueNestable,
        VueNestableHandle
    },
    props: ['resourceName', 'resourceId', 'panel'],

    data() {
      return {
          nestableItems: [],
      }
    },
    computed: {
        disable: function() {
            return  this.panel.fields[0].disable;
        },
        currentLang() {
            return this.$route.query.lang || window.config.locale;
        },
        displayName: function () {
            return this.panel.fields[0].display_name;
        }
    },
    methods: {
        change() {
            var ref = this;
            if(!this.disable){
                  window.axios.post('/nova-vendor/nest-tool/save-items', {
                      model: ref.panel.fields[0].model,
                      parent_column: ref.panel.fields[0].parent_column,
                      order_column: ref.panel.fields[0].order_column,
                      display_name: ref.panel.fields[0].display_name,
                      menus: ref.nestableItems,
                  }).then(function (response) {
                      ref.$toasted.show(ref.__('Items Ordered!'), { type: 'success' });
                  }).catch(function (error) {
                      ref.$toasted.show(ref.__('Error Occurred!'), { type: 'error' });
                  });
            } else {
                  ref.$toasted.show(ref.__('Sorting Disabled!'), { type: 'error' });
            }

        },
    },
  mounted() {
        var ref = this;
        window.axios.post('/nova-vendor/nest-tool/items', {
            model: ref.panel.fields[0].model,
            parent_column: ref.panel.fields[0].parent_column,
            order_column: ref.panel.fields[0].order_column,
            display_name: ref.panel.fields[0].display_name,
        }).then(function(response) {
            ref.nestableItems = _.values(response.data);
            ref.$toasted.show(ref.__('Items Fetched!'), { type: 'success' });
        }).catch(function (error) {
            ref.$toasted.show(ref.__('Error Occurred!'), { type: 'error' });
        });
  },
}
</script>

<style lang="scss">




/*
* Style for nestable
*/
.nestable {
    position: relative;
    .nestable-list {
        margin: 0;
        padding: 0 0 0 40px;
        list-style-type: none;
    }
    >.nestable-list {
        padding: 0;
    }
    [draggable='true'] {
        cursor: move;
    }
}
.nestable-item {
    margin: 10px 0 0;
    position: relative;
    &:first-child {
        margin-top: 0;
    }
    .nestable-list {
        margin-top: 10px;
    }
}
.nestable-item-copy {
    margin: 10px 0 0;
    &:first-child {
        margin-top: 0;
    }
    .nestable-list {
        margin-top: 10px;
    }
}
.nestable-item-content {
    border: 1px solid #ccc;
    background: #fafafa;
    -webkit-border-radius: 3px;
    border-radius: 3px;
    box-sizing: border-box;
}
.handle {
    width: 100%;
    padding: 0 10px;
    height: 45px;
    line-height: 45px;
}
.nestable-item.is-dragging {
    .nestable-list {
        pointer-events: none;
    }
    * {
        opacity: 0;
        filter: alpha(opacity=0);
    }
    &:before {
        content: ' ';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(106, 127, 233, 0.274);
        border: 1px dashed rgb(73, 100, 241);
        -webkit-border-radius: 5px;
        border-radius: 5px;
    }
}
.nestable-drag-layer {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 100;
    pointer-events: none;
    >.nestable-list {
        position: absolute;
        top: 0;
        left: 0;
        padding: 0;
        background-color: rgba(106, 127, 233, 0.274);
    }
}
.disabled {
    opacity: 0.5;
}
</style>
