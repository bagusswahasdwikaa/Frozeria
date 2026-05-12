<<header class="fixed top-0 left-0 right-0 z-40
            bg-[#1a237e]/95 backdrop-blur-md shadow-md">

    <div class="w-full px-4">

        <div class="flex items-center justify-between h-14">

            {{-- Brand --}}
            <a href="{{ route('barang.index') }}"
               class="text-white font-extrabold text-xl tracking-wide flex items-center gap-2">

                <i class="bi bi-snow2"></i>
                <span>Frozeria</span>

            </a>

            {{-- Mobile Toggle --}}
            <label for="nav-toggle"
                   class="lg:hidden text-white text-2xl cursor-pointer">

                <i class="bi bi-list"></i>

            </label>

            <input type="checkbox"
                   id="nav-toggle"
                   class="hidden peer">

            {{-- Navigation --}}
            <div class="hidden peer-checked:flex lg:flex
                        flex-col lg:flex-row
                        absolute lg:static
                        top-14 left-0 right-0
                        bg-[#1a237e] lg:bg-transparent
                        px-4 lg:px-0 py-3 lg:py-0
                        items-start lg:items-center
                        gap-2
                        w-full lg:w-auto">

                <ul class="flex flex-col lg:flex-row gap-1 flex-1">

                    {{-- Dashboard --}}
                    <li>
                        <a href="{{ route('barang.index') }}"
                           class="flex items-center gap-2
                                  px-4 py-2 rounded-lg text-sm
                                  transition-colors
                                  {{ request()->routeIs('barang.*')
                                      ? 'bg-white/20 text-white'
                                      : 'text-white/80 hover:bg-white/15 hover:text-white' }}">

                            <i class="bi bi-speedometer2"></i>
                            Dashboard

                        </a>
                    </li>

                    {{-- Kategori --}}
                    <li>
                        <a href="{{ route('kategori.index') }}"
                           class="flex items-center gap-2
                                  px-4 py-2 rounded-lg text-sm
                                  transition-colors
                                  {{ request()->routeIs('kategori.*')
                                      ? 'bg-white/20 text-white'
                                      : 'text-white/80 hover:bg-white/15 hover:text-white' }}">

                            <i class="bi bi-tags"></i>
                            Kategori

                        </a>
                    </li>

                    {{-- Bantuan --}}
                    <li>
                        <a href="{{ route('bantuan.index') }}"
                           class="flex items-center gap-2
                                  px-4 py-2 rounded-lg text-sm
                                  transition-colors
                                  {{ request()->routeIs('bantuan.*')
                                      ? 'bg-white/20 text-white'
                                      : 'text-white/80 hover:bg-white/15 hover:text-white' }}">

                            <i class="bi bi-question-circle"></i>
                            Bantuan

                        </a>
                    </li>

                </ul>

                {{-- Right Navbar --}}
                <div class="flex items-center">
                    @yield('navbar-right')
                </div>

            </div>

        </div>

    </div>

</header>