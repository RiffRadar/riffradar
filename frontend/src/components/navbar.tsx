import NavbarButton from './navbarButton'
import Image from 'next/image'

export default function Navbar() {
    return (
        <nav className="h-12 flex justify-between">
            <Image src={'/logo.svg'} alt={''} width={244} height={48} />

            <div className="flex justify-end gap-8">
                <NavbarButton
                    href="/home"
                    name="Home"
                    image="/home-2-line.svg"
                />
                <NavbarButton
                    href="/event"
                    name="Events"
                    image="/calendar-event-line.svg"
                />
                <NavbarButton
                    href="/band"
                    name="Bands"
                    image="/music-2-line.svg"
                />
                <NavbarButton href="/bar" name="Bars" image="/store-line.svg" />
            </div>
        </nav>
    )
}
