import NavbarButton from './navbarButton'

export default function Navbar() {
    return (
        <nav className="h-12 border border-blue-800">
            <NavbarButton href="/home" name="Accueil" />
        </nav>
    )
}
