#!/usr/bin/python
#
#  Copyright 2018 Isaac D. Arcilla (isaacdarcilla@gmail.com)
#
#   Licensed under the Apache License, Version 2.0 (the "License");
#   you may not use this file except in compliance with the License.
#   You may obtain a copy of the License at
#
#       http://www.apache.org/licenses/LICENSE-2.0
#
#   Unless required by applicable law or agreed to in writing, software
#   distributed under the License is distributed on an "AS IS" BASIS,
#   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
#   See the License for the specific language governing permissions and
#   limitations under the License. 

import pygtk
pygtk.require('2.0')
import gtk
import webkit
import gobject

class Browser:
    default_site = "http://localhost/" #Your web app link here

    def delete_event(self, widget, event, data=None):
        return False

    def destroy(self, widget, data=None):
        gtk.main_quit()

    def __init__(self):
        gobject.threads_init()
        self.window = gtk.Window(gtk.WINDOW_TOPLEVEL)
        self.window.resize(700, 480)
        #self.window.fullscreen()
        self.window.maximize()
        self.window.set_resizable(True)
        self.window.set_title("My Window")
        self.window.connect("delete_event", self.delete_event)
        self.window.connect("destroy", self.destroy)

        self.web_view = webkit.WebView()
        self.web_view.open(self.default_site)

        toolbar = gtk.Toolbar()

        self.back_button = gtk.ToolButton(gtk.STOCK_GO_BACK)
        self.back_button.connect("clicked", self.go_back)

        self.forward_button = gtk.ToolButton(gtk.STOCK_GO_FORWARD)
        self.forward_button.connect("clicked", self.go_forward)

        refresh_button = gtk.ToolButton(gtk.STOCK_REFRESH)
        refresh_button.connect("clicked", self.refresh)

        #toolbar.add(self.back_button)
        #toolbar.add(self.forward_button)
        #toolbar.add(refresh_button)

        self.url_bar = gtk.Entry()
        #self.url_bar.connect("activate", self.on_active)

        self.web_view.connect("load_committed", self.update_buttons)

        scroll_window = gtk.ScrolledWindow(None, None)
        scroll_window.add(self.web_view)
        

        vbox = gtk.VBox(False, 0)
        vbox.pack_start(toolbar, False, True, 0)
        #vbox.pack_start(self.url_bar, False, True, 0)
        vbox.add(scroll_window)

        self.window.add(vbox)
        self.window.show_all()

    def on_active(self, widge, data=None):
        url = self.url_bar.get_text()
        try:
            url.index("://")
        except:
            url = "http://"+url
        self.url_bar.set_text(url)
        self.web_view.open(url)

    def go_back(self, widget, data=None):
        self.web_view.go_back()

    def go_forward(self, widget, data=None):
        self.web_view.go_forward()

    def refresh(self, widget, data=None):
        self.web_view.reload()

    def update_buttons(self, widget, data=None):
        self.url_bar.set_text( widget.get_main_frame().get_uri() )
        self.back_button.set_sensitive(self.web_view.can_go_back())
        self.forward_button.set_sensitive(self.web_view.can_go_forward())

    def main(self):
        gtk.main()

if __name__ == "__main__":
    browser = Browser()
    browser.main()
